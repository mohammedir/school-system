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

class EngineeringOfferController extends Controller
{
    public function index(){

        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('teacher.projects_management.offers.list',compact('data'));
    }

    public function get_offers(Request $request)
    {
        $offers = EngineeringOffer::query()
            ->where('engineering_partner_id', Auth::id())
            ->with('project')
            ->orderBy('engineering_offers.id', 'desc')
        ;

        // فلترة حسب نوع المشروع إذا وُجد
        if ($request->filled('status_cd')) {
            $offers->where('status_cd', $request->status_cd);
        }



        return DataTables::of($offers)
            ->addColumn('project_title', function ($offers) {
                return '<div class="badge badge-info fw-bold">' . $offers->project->title . '</div>';
            })
            ->rawColumns(['project_title'])
            ->filterColumn('project_title', function ($query, $keyword) {
                $query->whereHas('project', function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('created_at', function ($offers) {
                $date = $offers->created_at ? $offers->created_at->format('Y-m-d') : '-';
                return '<div class="badge badge-light fw-bold">' . $date . '</div>';
            })
            ->editColumn('total_price', function ($offers) {
                return '<div class="badge badge-light-success fw-bold">' . number_format($offers->total_price) . ' $</div>';
            })
            ->editColumn('duration', function ($offers) {
                return '<div class="badge badge-light-primary fw-bold">' . $offers->duration . ' '.__('engineering.day') . '</div>';
            })
            ->editColumn('status_cd', function ($offers) {
                $locale = app()->getLocale();
                $status = $offers->statusLookup?->{'name_' . $locale} ?? '-';
                $extra_1 = $offers->statusLookup?->extra_1;
                $extra_2 = $offers->statusLookup?->extra_2;

                return '<span class="badge badge-light-'.$extra_1.'">
                    <i class="la la-' . e($extra_2) . '"></i>
                     '.$status.'
                </span>';
            })
            ->addColumn('actions', function ($offers) {
                $project = $offers->project;
                if (!$project || !$project->isCurrentlyAcceptingOffers()) {
                    return '';
                }

                $actions = '<div class="text-end">
            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </a>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                $actions .= '<div class="menu-item px-3">
            <a href="' . route('engineering.engineering_offers.show', $offers->id) . '" class="menu-link px-3 text-start">'
                    . trans('engineering.Edit a quote') . '</a>
         </div>';

                $actions .= '<div class="menu-item px-3">
            <a href="#" class="menu-link px-3 delete-btn"  data-item-id="' . $offers->id . '">'
                    . trans('engineering.delete a quote') . '</a>
         </div>';
                $actions .= '</div></div>';

                return $actions;
            })

            // ✅ ضيف هان
            ->setRowId(function ($offer) {
                return 'offer-' . $offer->id;
            })

            ->rawColumns(['project_title','total_price', 'duration','status_cd', 'created_at','actions'])
            ->make(true);
    }



    public function show($id){
        $data['my_offer'] = EngineeringOffer::query()->where('engineering_partner_id',Auth::id())->find($id);
        $data['project'] = Projects::find($data['my_offer']['project_id']);
        $data['land'] = $data['project']->lands;

        $data['attachments'] = Attachments::query()
            ->where('reference_type', 'projects_engineering_offer')
            ->where('reference_id_fk', $id)
            ->where('attachment_type_cd', 44)
            ->get();

        $data['settings'] = Settings::query()->find(1);


        return view('teacher.projects_management.offers.view.blade.php',$data);

    }
    public function delete(Request $request , $id){
        $item = EngineeringOffer::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
