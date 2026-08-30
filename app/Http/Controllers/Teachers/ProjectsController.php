<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\Attachments;
use App\Models\EngineeringOffer;
use App\Models\EngineeringPartner;
use App\Models\Investors;
use App\Models\Lands;
use App\Models\Lookups;
use App\Models\Projects;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProjectsController extends Controller
{
    public function index(){

        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('teacher.projects_management.list',compact('data'));
    }

    public function get_projects(Request $request)
    {
        $engineeringPartnerApprovedId = \App\Models\Lookups::where('master_key', 'engineering_partner_status')
            ->where('item_key', \App\Models\EngineeringPartner::STATUS_APPROVED)
            ->value('id');

        $engineeringPartner = EngineeringPartner::query()->find(Auth::id());

        // إذا لم يكن الشريك الهندسي موافق عليه، رجع DataTable فارغ
        if (!$engineeringPartner || $engineeringPartner->status_cd != $engineeringPartnerApprovedId) {
            return DataTables::of(collect([]))->make(true);
        }

        $projects = Projects::query()->whereDoesntHave('my_offer')->orderBy('id', 'desc');

        if ($request->filled('project_type_cd')) {
            $projects->where('project_type_cd', $request->project_type_cd);
        }

        $projects->CurrentlyAcceptingOffers();
        return DataTables::of($projects)
            ->addColumn('title', function ($projects) {
                return '<div class="badge badge-info fw-bold">' . $projects->title . '</div>';
            })
            ->rawColumns(['title'])
            ->filterColumn('title', function ($query, $keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
           ->addColumn('engineering_consultant_description', function ($projects) {
                $shortContent = strip_tags($projects->engineering_consultant_description);
                $contentWords = mb_strlen($shortContent);
                $shortContent =  \Str::words($shortContent, 5, '...');
                $fullContent = htmlspecialchars_decode($projects->engineering_consultant_description);
                if($contentWords > 50){
                return '<div class="fw-bold">
                        <span class="notes-preview"
                            data-bs-toggle="tooltip"
                            title="'. strip_tags($fullContent) .'">
                            '. strip_tags($shortContent) .'
                        </span>
                        <button class="btn btn-sm btn-link p-0 ms-1 view.blade.php-notes"
                                data-bs-toggle="modal"
                                data-bs-target="#notesModal"
                                data-notes="'. strip_tags($fullContent) .'">
                            (عرض المزيد)
                        </button>
                        </div>';
                }else{
                    return strip_tags($fullContent);
                }
            })
            ->addColumn('project_status_cd', function ($projects) {
                return '<div class="badge badge-light-' . $projects->statusLookup?->extra_1 . '"> <i class="la la-' . $projects->statusLookup?->extra_2 . ' text-' . $projects->statusLookup?->extra_1 . ' fw-bold "></i>' . getlookup($projects->project_status_cd)->{'name_' . app()->getLocale()} . '</div>';
            })
            ->addColumn('actions', function ($projects) {
                $actions = '<div class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                <i class="ki-duotone ki-down fs-5 ms-1"></i>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                $actions .= '<div class="menu-item px-3">
                        <a href="' . route('engineering.projects.show', $projects->id) . '" class="menu-link px-3 text-start">'
                    . trans('engineering.Submit a quote') . '</a>
                     </div>';

                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['title', 'engineering_consultant_description', 'project_status_cd', 'actions'])
            ->make(true);
    }


    public function show($id){
        $data['project'] = Projects::find($id);
        $data['my_offer'] = EngineeringOffer::query()->where(['engineering_partner_id'=>Auth::id(),'project_id'=>$id])->first();
        $data['land'] = $data['project']->lands;
        $data['settings'] = Settings::query()->find(1);

        return view('teacher.projects_management.view.blade.php',$data);

    }

    public function getInvestorDetails(Request $request)
    {
        $investor = Investors::find($request->id);
        if (!$investor) {
            return response()->json('Student not found', 404);
        }
        return view('admin.Students.ajax.investor_details', compact('investor'))->render();
    }
    public function getLandDetails(Request $request){
        $land = Lands::find($request->id);
        if (!$land) {
            return response()->json('Student not found', 404);
        }
        /*return view.blade.php('admin.Projects.ajax.land_details', compact('land'))->render();*/
        return view('teacher.projects_management.ajax.land_details', compact('land'))->render();
    }

    public function submit_quote(Request $request,$project_id){

        try {
            // Validate the request data
            $validated = $request->validate([
                'total_price' => 'required',
                'duration' => 'required',

            ]);
            $offer= EngineeringOffer::query()->updateOrCreate(
                [
                    'engineering_partner_id' => Auth::id(),
                    'project_id' => $project_id,
                ],[
                    'total_price'=>str_replace(',', '', $request->total_price),
                    'duration'=>$request->duration,
                    'offer_notes'=>$request->offer_notes??null,
                ]
            );

            foreach ($request->kt_docs_repeater_basic as $item) {
                if (isset($item['projects_offer_attachment']) && $item['projects_offer_attachment'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $item['projects_offer_attachment'];
                    $fileType = $file->getMimeType();
                    $originalName = $file->getClientOriginalName();
                    $filePath = 'uploads/projects/attachments/' . $originalName;

                    $file->move(public_path('uploads/projects/attachments'), $originalName);

                    Attachments::create([
                        'reference_type' => 'projects_engineering_offer',
                        'reference_id_fk' => $offer->id,
                        'attachment_type_cd' => 44,
                        'created_by' => Auth::id(),
                        'file_type' => $fileType,
                        'file_path' => $filePath,
                        'original_name' => $originalName,
                        'user_type' => 'EngineeringPartner',
                        'file_description' => $item['description'] ?? null,
                    ]);

                }
            }


            return response()->json([
                'status' => 'success',
                'message' => __('engineering.Quote submitted successfully'),
                'redirect' => route('engineering.engineering_offers.index')
            ]);

        }catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e){
            // Return general error
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
