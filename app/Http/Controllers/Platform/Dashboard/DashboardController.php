<?php

namespace App\Http\Controllers\Platform\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\SendGenericMail;
use App\Models\Attachments;
use App\Models\ContractorOffers;
use App\Models\DepositRequests;
use App\Models\EngineeringOffer;
use App\Models\Investors;
use App\Models\Lands;
use App\Models\Lookups;
use App\Models\ProjectBalanceLog;
use App\Models\ProjectLog;
use App\Models\Projects;
use App\Models\ProjectUnit;
use App\Models\Settings;
use App\Models\Shares;
use App\Models\Transactions;
use App\Models\User;
use App\Notifications\AddLandNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use Yajra\DataTables\DataTables;
use App\Services\SMSService;

class DashboardController extends Controller
{
    protected $smsService;

    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function index()
    {
        return view('site.dashboard.index');
    }


    public function add_project(Request $request,$land_id = null)
    {
        if (!auth()->user()->isActive()) {
            return redirect(route('investors.dashboard.index'));
        }
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        $data['lands'] = Lands::query()
            ->where('status_cd', 1)
            ->get()
            ->filter(function ($land) {
                return $land->isValuationApproved() && $land->isLegalApproved();
            });
        $data['land_id'] = $land_id ;
        $data['land'] = Lands::query()->find($land_id);
        $data['investors'] = Investors::query()->get();

        $data['investor'] = Investors::query()->find(Auth::id());
        $data['investor_balance'] = $data['investor']->balance;

        if (request()->isMethod('post')) {
            try {
                // Validate the request data
                $validated = $request->validate([
                    'land_id' => 'required',
                    'title' => 'required',
                    'project_cost' => 'required',
                    'project_type_cd' => 'required',
                    'area' => 'required',
                ]);

                DB::beginTransaction();

                // التحقق من كفاية الرصيد (10% من تكلفة المشروع)
                $project_cost = (float) str_replace(',', '', $request->project_cost);
                $required_balance = $project_cost * 0.1;

                $investor = Investors::findOrFail(Auth::id());

                if ($investor->balance < $required_balance) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Your balance is insufficient. Required: ' . $required_balance . ', Your balance: ' . $investor->balance);
                }

                // إنشاء معاملة
                $transactions = new Transactions();
                $transactions->user_type = 'investor';
                $transactions->user_id = $investor->id;
                $transactions->amount = $required_balance;
                $transactions->balance_before = $investor->balance;

                // خصم الرصيد
                $investor->decrement('balance', $required_balance);

                $transactions->balance_after = $investor->balance;
                $transactions->markAsCreate_Project();
                $transactions->save();

                // إنشاء المشروع
                $project = new Projects();
                $project->land_id = $request->land_id;
                $project->title = $request->title;
                $project->project_type_cd = $request->project_type_cd;
                $project->markAsNew();
                $project->setEvaluationStatus('pending');
                $project->setProjectApprovalStatus('pending');
                $project->setAwardedStatus('pending');
                $project->area = $request->area;
                $project->project_cost = $project_cost;
                $project->offers_start_date = $request->offers_start_date;
                $project->offers_end_date = $request->offers_end_date;
                $project->description = $request->description;
                $project->project_balance = $required_balance;
                $project->creator_investor_id = $investor->id;

                // تحقق من وجود الصورة
                if ($request->hasFile('project_logo')) {
                    $image = $request->file('project_logo');
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/projects/project_logos'), $imageName);
                    $project->project_logo = 'project_logos/' . $imageName;
                }

                $project->save();

                // حفظ سجل المشروع
                ProjectLog::create([
                    'project_id' => $project->id,
                    'action' => 'addNewProject',
                    'user_id' => $investor->id,
                    'user_type' => 'investor',
                    'description' => 'تم إضافة مشروع جديد',
                    'notes' => 'لا يوجد ملاحظات',
                ]);

                // حفظ سجل رصيد المشروع
                ProjectBalanceLog::create([
                    'project_id' => $project->id,
                    'user_type' => 'investor',
                    'user_id' => $investor->id,
                    'transaction_type' => 1,
                    'amount' => $required_balance,
                    'transaction_id' => $transactions->id,
                ]);

                DB::commit();

                return redirect()->route('investors.dashboard.my_projects')
                    ->with('success', "تم إضافة المشروع بنجاح");

            } catch (\Illuminate\Validation\ValidationException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        return view('site.dashboard.projects.add_project',$data);

    }

    public function view_project($project_id)
    {
        $data['project'] = Projects::query()->find($project_id);
        $data['projectLogs'] = ProjectLog::query()->orderBy('id','desc')->where('project_id',$project_id)->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        $data['lands'] = Lands::query()
            ->where('status_cd', 1)
            ->get()
            ->filter(function ($land) {
                return $land->isValuationApproved() && $land->isLegalApproved();
            });
        $data['land_id'] = $data['project']->land_id ;
        $data['land'] = Lands::query()->find($data['project']->land_id);
        $data['investors'] = Investors::query()->get();
        $data['investor'] = Investors::query()->find(Auth::id());
        $data['investor_balance'] = $data['investor']->balance;
        return view('site.dashboard.projects.view_project',$data);
    }
    public function my_projects()
    {
        $data['projects'] = Projects::query()->where('creator_investor_id', Auth::id())->latest()->paginate(6);
        return view('site.dashboard.projects.my_projects',$data);
    }
    public function delete_land($land_id)
    {
        $land = Lands::query()->find($land_id);
        if ($land) {
            $land->delete();
            return redirect()->route('investors.dashboard.my_land')
                ->with('success', "تم حذف الارض بنجاح");
        }

    }
    public function award_modal($id)
    {
        $offer = EngineeringOffer::with('project', 'teacher')->findOrFail($id);


        return view('site.dashboard.projects.ajax.award_approval_modal', compact('offer'));
    }
    public function contractor_award_modal($id)
    {
        $offer = ContractorOffers::with('project', 'contractor')->findOrFail($id);

        return view('site.dashboard.projects.ajax.contractor_award_approval_modal', compact('offer'));
    }
    public function store_award_approval(Request $request, $offer_id)
    {
        // الحصول على العرض
        $offer = EngineeringOffer::with('project')->findOrFail($offer_id);
        // الحصول على المشروع المرتبط بالعرض
        $project = $offer->project;
        $offer->setStatus('approved');
        $offer->save();

        EngineeringOffer::where('project_id', $project->id)
            ->where('id', '!=', $offer->id)
            ->update([
                'status_cd' => Lookups::getEngineeringOfferStatusId('rejected'),
            ]);
        // تنفيذ التحديث
        $project->update([
            'awarded_engineering_creator_approval_date' => now(),
        ]);
        $project->markAwardedStatusAsApproved()->save();
        $project->markAsAwardingApproved()->save();
        // تغيير الحالة إذا في عندك منطق لذلك
        $project->markAsAwarded();

        $project_log = new ProjectLog();
        $project_log->project_id = $project->id;
        $project_log->action = 'storeAwardApproval' ;
        $project_log->user_id = Auth::id();
        $project_log->description = 'تم اعتماد الترسية للمشروع' ;
        $project_log->notes = 'لا يوجد ملاحظات' ;

        $project_log->save();

        Projects::where('land_id', $project->land_id)
            ->where('id', '!=', $project->id)
            ->update(['project_status_cd' => Lookups::getStatusId('canceled')]);
        Lands::where('id',$project->land_id)->update(['status_cd' => 0]);
        return response()->json([
            'success' => true,
            'message' => __('engineering.The operation was successful.'),
        ]);
    }
    public function store_contractor_award_approval(Request $request, $offer_id)
    {


        // الحصول على العرض
        $offer = ContractorOffers::with('project')->findOrFail($offer_id);
        // الحصول على المشروع المرتبط بالعرض
        $project = $offer->project;
        $offer->setStatus('approved');
        $offer->save();

        ContractorOffers::where('project_id', $project->id)
            ->where('id', '!=', $offer->id)
            ->update([
                'status_cd' => Lookups::getContractorOfferStatusId('rejected'),
            ]);
        // تنفيذ التحديث
        $project->update([
            'awarded_contractor_creator_approval_date' => now(),
        ]);
        $project->markAwardedContractorStatusAsApproved()->save();
        $project->markAsContractorAwardingApproved()->save();
        // تغيير الحالة إذا في عندك منطق لذلك
        //$project->markAsContractorAwarded();

        $project_log = new ProjectLog();
        $project_log->project_id = $project->id;
        $project_log->action = 'storeContractorAwardApproval' ;
        $project_log->user_id = Auth::id() ;
        $project_log->description = 'تم اعتماد الترسية على مقاول ' ;
        $project_log->notes = 'لا يوجد ملاحظات' ;

        $project_log->save();


        return response()->json([
            'success' => true,
            'message' => __('engineering.The operation was successful.'),
        ]);
    }

    public function profile()
    {
        $user= Auth::user();
        return view('site.dashboard.profile.index',compact('user'));

    }
    public function emailOtp()
    {
        $user = Auth::guard('investors')->user();

        $user->otp_code = rand(100000, 999999);
        $user->otp_code_expires_at = now()->addMinutes(10);
        $user->save();

        $subject = __('رمز التحقق');
        $view_file = 'emails.otp_verification';
        $body_data = [
            'otp_code' => $user->otp_code,
            'user' => $user,
        ];

        Mail::to($user->email)->send(new SendGenericMail($subject, $body_data, $view_file));

        return response()->json(['success' => true]);

    }
    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = $request->otp_code;

        $user = Auth::guard('investors')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }
        // تحقق من الكود وانتهاء صلاحيته
        if ($user->otp_code === $otp && $user->otp_code_expires_at > now()) {
            // يمكن هنا تحديث حالة التفعيل أو أي شيء آخر
            $user->otp_code = null; // امسح الكود بعد التحقق
            $user->otp_code_expires_at = null;
            $user->email_verified_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => trans('admin.Verification successful!'),
                'redirect_url' => route('investors.dashboard.profile'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code.',
        ], 422);
    }

    public function smsOtp()
    {
        $user = Auth::guard('investors')->user();

        $user->otp_code = rand(100000, 999999);
        $user->otp_code_expires_at = now()->addMinutes(10);
        $user->save();

        $message = "رمز التحقق الخاص بك هو: {$user->otp_code}. يرجى عدم مشاركة الرمز";

        $success = $this->smsService->sendSMS(
            $user->mobile,
            $message
        );

        if ($success) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

    }
    public function verifySmsOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = $request->otp_code;

        $user = Auth::guard('investors')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }
        // تحقق من الكود وانتهاء صلاحيته
        if ($user->otp_code === $otp && $user->otp_code_expires_at > now()) {
            // يمكن هنا تحديث حالة التفعيل أو أي شيء آخر
            $user->otp_code = null; // امسح الكود بعد التحقق
            $user->otp_code_expires_at = null;
            $user->mobile_verified_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => trans('admin.Verification successful!'),
                'redirect_url' => route('investors.dashboard.profile'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'الكود المدخل غير صحيح أو منتهي الصلاحية',
        ], 422);
    }

    public function sendVerifyData(Request $request)
    {
        $investors = Investors::query()->find(Auth::user()->id);
        if ($request->hasFile('photo_personal_id')) {

            $image = $request->file('photo_personal_id');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // احفظها في مجلد عام مثل public/project_logos
            $image->move(public_path('uploads/investors/'), $imageName);

            // خزّن الاسم في قاعدة البيانات
            $investors->photo_personal_id = 'investors/' . $imageName;
        }
        if ($request->hasFile('photo_with_id')) {

            $image = $request->file('photo_with_id');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // احفظها في مجلد عام مثل public/project_logos
            $image->move(public_path('uploads/investors/'), $imageName);

            // خزّن الاسم في قاعدة البيانات
            $investors->photo_with_id = 'investors/' . $imageName;
        }
        if ($investors->isNew()){
            $investors->markAsPending();
        }elseif ($investors->isRejected()){
            $investors->markAsUpdated();
        }

        $investors->save();
        return redirect(route('investors.dashboard.profile'));

    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:investors,email,' . auth()->id(),
        ], [
            'email.unique' => 'هذا البريد مستخدم من قبل مستثمر آخر.',
        ]);

        $user = auth()->user();
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البريد الإلكتروني بنجاح، يرجى التحقق من بريدك الجديد.'
        ]);
    }
    public function updateMobile(Request $request)
    {
        $request->validate([
            'mobile' => 'required|unique:investors,mobile,' . auth()->id(),
        ], [
            'mobile.unique' => 'هذا الهاتف مستخدم من قبل مستثمر آخر.',
        ]);

        $user = auth()->user();
        $user->mobile = $request->mobile;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث رقم الهاتف بنجاح، يرجى التحقق من الهاتف الجديد.'
        ]);
    }

    public function my_wallet()
    {
        $data["payment_method_cd"] = Lookups::query()
            ->where("master_key", "payment_method_cd")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();
        $data["banks_cd"] = Lookups::query()
            ->where("master_key", "banks")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();
        $data['investor'] = Investors::query()->find(Auth::id());
        $data['pending_deposit_requests_sum'] = DepositRequests::where('user_type', 'investor')
            ->where('user_id', Auth::id())
            ->where('deposit_request_status_cd', getlookupId('deposit_request_status_cd', 'pending'))
            ->sum('amount');
        return view('site.dashboard.wallet.index',$data);

    }
    public function deposit_requests(Request $request)
    {
        if ($request->isMethod('post')) {
            $depositRequests = new DepositRequests();
            $depositRequests->user_id = auth()->id();
            $depositRequests->amount = str_replace(',', '', $request->amount);;
            $depositRequests->reference_number = $request->reference_number;
            $depositRequests->payment_date = $request->payment_date;
            $depositRequests->payment_method_cd = $request->payment_method_cd;
            $depositRequests->bank_name = $request->bank_name;
            $depositRequests->payment_notes = $request->payment_notes;
            if ($request->hasFile('payment_proof')) {

                $image = $request->file('payment_proof');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // احفظها في مجلد عام مثل public/project_logos
                $image->move(public_path('uploads/investors/payment_proof'), $imageName);

                // خزّن الاسم في قاعدة البيانات
                $depositRequests->payment_proof = 'payment_proof/' . $imageName;
            }
            $depositRequests->save();
            return redirect()->route('investors.dashboard.wallet');

        }
        $depositRequests = DepositRequests::query()->orderBy('id', 'desc')->where('user_id',Auth::id());
        return DataTables::of($depositRequests)
            ->addColumn('amount', function ($depositRequests) {
                return '$' . number_format($depositRequests->amount);
            })
            ->addColumn('payment_date', function ($depositRequests) {
                return '<div style="font-size: 11px" class="vam">' . $depositRequests->payment_date . '</div>';
            })
            ->addColumn('payment_method_cd', function ($depositRequests) {
                return '<div class="vam">
                            <span class="pending-style style' . $depositRequests->statusLookup?->payment_method_cd . '">'.($depositRequests->statusLookup?->{'name_' . app()->getLocale()} ?? '-').'</span>
                        </div>';
            })
            ->addColumn('bank_name', function ($depositRequests) {
                return '<div class="vam">
                            <span class="pending-style">'.$depositRequests->bank_name.'</span>
                        </div>';
            })
            ->addColumn('deposit_request_status_cd', function ($depositRequests) {
                return '<div class="vam">
                            <span class="pending-style  bg-' . $depositRequests->depositRequestStatusLookup?->extra_1 . '">'.($depositRequests->depositRequestStatusLookup?->{'name_' . app()->getLocale()} ?? '-').'</span>
                        </div>';
            })
            ->addColumn('actions', function ($depositRequests) {
                $buttons = '<div class="d-flex gap-2">';

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['amount','payment_date','payment_method_cd','bank_name','deposit_request_status_cd', 'actions'])
            ->make(true);
    }

    public function transactions(Request $request)
    {
        $data['investor'] = Investors::query()->find(Auth::id());
        return view('site.dashboard.wallet.transactions',$data);

    }
    public function get_transactions(Request $request)
    {
        $transactions = Transactions::query()->orderBy('id', 'desc')->where('user_id',Auth::id());
        return DataTables::of($transactions)
            ->addColumn('amount', function ($transactions) {
                return '<span class="fs-6 fw-bold text-' . $transactions->statusLookup?->extra_1 . '">' . '$' . number_format($transactions->amount) . '</span>';
            })
            ->addColumn('created_at', function ($transactions) {
                return '<div style="font-size: 11px" class="vam">' . $transactions->created_at . '</div>';
            })
            ->addColumn('balance_before', function ($transactions) {
                return '<div >' . number_format($transactions->balance_before) . '</div>';
            })
            ->addColumn('balance_after', function ($transactions) {
                return '<div >' . number_format($transactions->balance_after) . '</div>';
            })
            ->addColumn('transaction_type_cd', function ($transactions) {
                return '<div class="vam">
                            <span class="pending-style  bg-' . $transactions->statusLookup?->extra_1 . '">'.($transactions->statusLookup?->{'name_' . app()->getLocale()} ?? '-').'</span>
                        </div>';
            })

            ->rawColumns(['amount','created_at','balance_before','balance_after','transaction_type_cd'])
            ->make(true);

    }

    public function notifications_list()
    {

        return response()->json([
            'notifications' => auth('investors')->user()
                ->notifications()
                ->latest() // order by created_at descending
                ->take(10) // limit to 10
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'data' => $notification->data,
                        'created_at_human' => $notification->created_at->diffForHumans(),
                        'read_at' => $notification->read_at,
                        'notifiable_type' => 'App\Models\investors',
                    ];
                }),
        ]);
    }
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'all-read']);
    }
    public function markAsRead($id)
    {
        auth()->user()->unreadNotifications()->where('id', $id)->first()?->markAsRead();
        return response()->json(['status' => 'done']);
    }

    public function check_balance(Request $request)
    {

        $unitId = $request->input('unitId');
        $unit = ProjectUnit::findOrFail($unitId);

        $totalQuantityUnitShares  = Shares::query()->where('unit_id', $unitId)
                ->sum('quantity');

        $investor = Investors::query()->find(Auth::id());
        $project = Projects::query()->find($unit->project_id);

        $shortage = 0;

        $required_balance = $unit->share_price;
        if ($investor->balance < $required_balance) {
            $shortage = $required_balance - $investor->balance ;
        }
        $availableShares = $unit->total_shares - $totalQuantityUnitShares;
        $availableSharesToBuy = floor(($investor->balance)/$unit->share_price);
        if ($availableSharesToBuy > $availableShares)
        {
            $availableSharesToBuy = $availableShares;
        }
        return response()->json([
            'status'          => $shortage > 0 ? 'error' : 'ok',
            'availableShares' => $availableShares,
            'total_shares'  => $unit->total_shares,
            'unitId'  => $unitId,
            'projectId'  => $unit->project_id,
            'availableSharesToBuy'  => $availableSharesToBuy,
        ]);
    }

    public function buy_shares(Request $request)
    {
        try {
            $unit = ProjectUnit::findOrFail($request->unitId);
            $investor = Investors::query()->find(Auth::id());

            $totalAmount = $request->shares * $unit->share_price;

            // التحقق من الرصيد
            if ($totalAmount > $investor->balance) {
                $shortage = $totalAmount - $investor->balance;

                return response()->json([
                    'status'  => 'error',
                    'message' => __('admin.Insufficient balance') .
                        '. ' . __('admin.You need to add') . ' ' .
                        number_format($shortage, 2) . ' ' . __('admin.to your wallet')
                ], 400);
            }

            $shares = new Shares();
            $shares->unit_id = $request->unitId;
            $shares->investor_id = Auth::id();
            $shares->quantity = $request->shares;
            $shares->price_per_share = $unit->share_price;
            $shares->total_amount = $request->shares * $unit->share_price;
            $shares->status_cd = 20;
            $shares->save();
            $investor->balance -= $shares->total_amount;
            $investor->save();

            return response()->json([
                'status' => 'success',
                'message' => __('admin.The shares have been successfully purchased.'),
                'data' => [
                    'shares' => $shares->quantity,
                    'total'  => $shares->total_amount,
                    'price'  => $shares->price_per_share,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.Something went wrong, please try again'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function my_stock_portfolio(Request $request)
    {
        $data['investor'] = Investors::query()->find(Auth::id());

        return view('site.dashboard.wallet.my_stock_portfolio',$data);
    }


}
