<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\EngineeringOffer;
use App\Models\ProjectLog;
use App\Models\Projects;
use App\Models\ProjectUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyProjectsController extends Controller
{
    //

    public function index()
    {
        return view('teacher.projects_management.my_projects.list');

    }

    public function getProjectsDetails(Request $request)
    {
        $projects = Projects::find($request->id);
        if (!$projects) {
            return response()->json('Project not found', 404);
        }
        return view('teacher.projects_management.ajax.project_details', compact('projects'))->render();

    }

    public function enter_units($id)
    {
        $awardingApprovedId = \App\Models\Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', \App\Models\Projects::PROJECT_STATUS_ENGINEERING_AWARDING_APPROVED)
            ->value('id');
        $unitsAddedId = \App\Models\Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', \App\Models\Projects::PROJECT_STATUS_UNITS_ADDED)
            ->value('id');
        $data['offers'] = EngineeringOffer::query()
            ->where('engineering_partner_id', Auth::id())
            ->whereHas('project', function ($q) use ($awardingApprovedId, $unitsAddedId) {
                $q->whereIn('project_status_cd', [$awardingApprovedId, $unitsAddedId]);
            })
            ->with('project')
            ->orderBy('engineering_offers.id', 'desc')->get()
        ;
        // 2. Get all floors for this project
        $data['floors'] = ProjectUnit::where('project_id', $id)
            ->where('parent_id', 0)
            ->with('children')
            ->get();
        $data['project'] = Projects::query()->find($id);
        $data['project_id'] = $id;
        return view('teacher.projects_management.my_projects.enter_units',$data);

    }
    public function get_awardingApproved_offers(Request $request)
    {
        $awardingApprovedId = \App\Models\Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', \App\Models\Projects::PROJECT_STATUS_ENGINEERING_AWARDING_APPROVED)
            ->value('id');
        $offerApprovedId = \App\Models\Lookups::where('master_key', 'engineering_offer_status')
            ->where('item_key', \App\Models\EngineeringOffer::STATUS_APPROVED)
            ->value('id');

        $unitsAddedId = \App\Models\Lookups::where('master_key', 'project_status_cd')
            ->where('item_key', \App\Models\Projects::PROJECT_STATUS_UNITS_ADDED)
            ->value('id');

        $offers = EngineeringOffer::query()
            ->where('engineering_partner_id', Auth::id())
            ->where('status_cd', $offerApprovedId)
            ->whereHas('project', function ($q) use ($awardingApprovedId) {
                $q->where('project_status_cd', '>=', $awardingApprovedId);
            })
            ->with('project')
            ->orderBy('engineering_offers.id', 'desc')
            ->get();
        return DataTables::of($offers)
            ->addColumn('project_title', function ($offers) {
                return '<div class="badge badge-info fw-bold">' . $offers->project->title . '</div>';
            })
           ->addColumn('description', function ($offers) {
                $shortContent = strip_tags($offers->project->engineering_consultant_description);
                $contentWords = mb_strlen($shortContent);
                $shortContent =  \Str::words($shortContent, 5, '...');
                $fullContent = htmlspecialchars_decode($offers->project->engineering_consultant_description);
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
            ->addColumn('project_type_cd', function ($offers) {

                return '<div class="badge badge-light-success fw-bold">' . getlookup($offers->project->project_type_cd)->name_ar . '</div>';
            })
            ->addColumn('area', function ($offers) {

                return '<div class="badge badge-light-primary fw-bold">' . $offers->project->area . 'م2</div>';
            })
            ->addColumn('project_cost', function ($offers) {

                return '<div class="badge badge-light-primary fw-bold">' . getSettings()->currency_symbol . number_format($offers->project->project_cost) . '</div>';
            })
            ->addColumn('actions', function ($offers) use ($awardingApprovedId) {

                $actions = '<div class="text-end">
        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
        <i class="ki-duotone ki-down fs-5 ms-1"></i>
    </a>
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';
                if ($offers->project->project_status_cd == $awardingApprovedId) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . route('engineering.my_projects.enter_units', $offers->project->id) . '" class="menu-link px-3 text-start">'
                        . trans('engineering.Enter Units') . '</a>
                             </div>';
                }else{
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . route('engineering.my_projects.enter_units', $offers->project->id) . '" class="menu-link px-3 text-start">'
                        . trans('engineering.View units') . '</a>
                             </div>';
                }

                $actions .= '</div></div>';

                return $actions;
            })

            //
            ->rawColumns(['project_title','description', 'project_type_cd','area', 'project_cost','actions'])
            ->make(true);
    }

    public function saveProjectUnits(Request $request)
    {

        $request->validate([
            'floors.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2072', // 3MB
        ]);

        $action = $request->input('action');

        ProjectUnit::where('project_id', $request->project_id)->delete();
        foreach ($request->floors as $floorData) {
            // أنشئ الطابق
            $floor = new ProjectUnit();
            $floor->description = $floorData['description'];
            $floor->project_id = $request->project_id;
            $floor->parent_id = 0;
            if (isset($floorData['image'])) {
                $image = $floorData['image'];
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // احفظها في مجلد عام مثل public/uploads/projects/project_floor_images
                $image->move(public_path('uploads/projects/project_floor_images'), $imageName);

                // خزّن المسار في قاعدة البيانات
                $floor->image = 'project_floor_images/' . $imageName;
            }else {
                $floor->image = $floorData['hidden_image'];
            }
            $floor->save();

           /* $floor = ProjectUnit::create([
                'description' => $floorData['description'],
                'project_id' => $request->project_id,
                'parent_id' => 0,
            ]);*/

            // إذا فيه وحدات
            if (!empty($floorData['units'])) {
                foreach ($floorData['units'] as $unitData) {
                    ProjectUnit::create([
                        'description' => $unitData['description'],
                        'project_id' => $request->project_id,
                        'parent_id' => $floor->id,
                        'unit_type_cd' => $unitData['unit_type_cd'] ?? null,
                        'area' => $unitData['area'] ?? null,
                        'rooms' => $unitData['rooms'] ?? null,
                        'bathrooms' => $unitData['bathrooms'] ?? null,
                        'finishing_details' => $unitData['finishing_details'] ?? null,
                    ]);
                }
            }
        }
        if ($action === 'send_to_valuation') {
            $project = Projects::query()->find($request->project_id);
            $project->markAsUnitsAdded();
            $project->save();

            $project_log = new ProjectLog();
            $project_log->project_id = $project->id;
            $project_log->action = 'sendToValuationUnitsProject' ;
            $project_log->engineering_partner_id = Auth::id();
            $project_log->description = 'تم ادخال الوحدات للتثمين';
            $project_log->notes = 'الرجاء من المثمن تثمين الوحدات باسرع وقت' ;
            $project_log->save();

            return redirect()->back()->with('success', 'تم ارسال الوحدات وتغيير الحالة بنجاح');
        }

        return redirect()->back()->with('success', 'تم حفظ الطوابق والوحدات بنجاح!');
    }

}
