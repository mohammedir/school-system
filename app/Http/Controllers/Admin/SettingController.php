<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investors;
use App\Models\Lookups;
use App\Models\Settings;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class SettingController extends Controller
{
    public function index(Request $request){
        $data['settings'] = Settings::get()->first();
        if ($request->formId == 'kt_ecommerce_settings_general_form'){
            $data['settings']->currency_name = $request->currency_name;
            $data['settings']->currency_symbol = $request->currency_symbol;

            // رفع ملف نموذج الأراضي إن وجد
            if ($request->hasFile('land_template_file')) {
                $file = $request->file('land_template_file');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $filename);

                // حفظ اسم الملف في نفس السجل
                $data['settings']->land_template_file = $filename;
            }
            // رفع ملف نموذج الهندسي إن وجد
            if ($request->hasFile('engineering_template_file')) {
                $file = $request->file('engineering_template_file');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $filename);

                // حفظ اسم الملف في نفس السجل
                $data['settings']->engineering_template_file = $filename;
            }
            // رفع ملف نموذج المقاول إن وجد
            if ($request->hasFile('contractor_template_file')) {
                $file = $request->file('contractor_template_file');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $filename);

                // حفظ اسم الملف في نفس السجل
                $data['settings']->contractor_template_file = $filename;
            }

            $data['settings']->save();
            return response()->json([
                'status' => 'success',
                'message' => __('admin.General Setting Updated successfully'),
                'redirect' => route('settings.general')
            ]);
        }

        return view('admin.SystemSettings.settings',$data);
    }

    public function manage_lists(){
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["city"] = Lookups::query()->where([
            "master_key" => "city"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["age_group"] = Lookups::query()->where([
            "master_key" => "age_group"
        ])->whereNot("parent_id", 0)->where("status", 1)->where('level',null)->get();
        $data['lookups'] = Lookups::query()->where('is_managed',1)->where('parent_id',0)->get();
        return view('admin.SystemSettings.manageList',$data);
    }
    public function settings_list(Request $request,$id){
        $data["lookups"] = Lookups::query()->find($id);
        $data["items"] = Lookups::query()->where('is_managed',1)->where('parent_id',$id);
        return response()->json($data);

    }
    public function add_item(Request $request){
        try {
            // Validate the request data
            $validated = $request->validate([
                'settings_name_id' => 'required',
            ]);
                $lookups = new Lookups();
                $list = Lookups::query()->find($request->settings_name_id);
                $lookups->is_managed = 1;
                if ($request->province_cd){
                    if ($request->city_cd){
                        $lookups->parent_id = $request->city_cd;
                    }
                }if ($request->age_group){
                    $lookups->parent_id = $request->age_group;
                    $lookups->level = 2;
                }else{
                        $lookups->parent_id = $request->settings_name_id;

                }
                $lookups->master_key = $list->master_key;

                $lookups->name_ar = $request->name_ar;
                $lookups->status = 1;

                $lookups->save();

                return response()->json([
                    'status' => 'success',
                    'message' => __('admin.Item List Added Successfully'),
                    'redirect' => route('settings.manage_lists')
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
    public function edit_item(Request $request , $id){
       $list = Lookups::query()->find($id);
       $list->name_ar = $request->edit_name_ar;
       $list->status = $request->status;

       $list->save();
        return response()->json([
            'status' => 'success',
            'message' => __('admin.Item List Updated Successfully'),
            'redirect' => route('settings.manage_lists')
        ]);

    }

    public function delete_item(Request $request , $id){
        $item = Lookups::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
    public function get_manage_lists_data(Request $request){
        $lookups = Lookups::query()->where('is_managed',1)->where('parent_id','!=',0);
        if ($request->filled('list_name_cd')) {
            $lookups->where('master_key', 'like', '%' . $request->list_name_cd . '%');
        }
        return DataTables::of($lookups)
            ->addColumn('list_name', function ($lookups) {
                return '<div class="badge badge-light fw-bold">' . $lookups->parent->{'name_' . app()->getLocale()} ?? '-' . '</div>';
            })
            ->filterColumn('list_name', function($query, $keyword) {
                $query->where('name_ar', 'like', "%{$keyword}%");;
            })
            ->addColumn('item_name', function ($lookups) {
                return '<div class="badge badge-light fw-bold">' . $lookups->{'name_' . app()->getLocale()} ?? '-' . '</div>';
            })
            ->addColumn('status', function ($lookups) {
                return '<a class="view_items" href="#" data-settings-list-id="' .$lookups->id .'" data-bs-toggle="modal" data-bs-target="#kt_modal_view_items"><span class="badge badge-light-' . $lookups->status_badge_class . '"> <i class="la la-' . $lookups->extra_2 . ' text-' . $lookups->extra_1 . '"></i> '.($lookups->status_text).'</span></a>';
            })
            ->addColumn('actions', function ($lookups) {
                $actions = '<div class="text-end">
                        <a href="#" class="btn btn-light btn-active-light-info btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'
                    . trans('admin.Actions') . '
                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                if (auth()->user()->can('List edit')) {
                    $actions .= '<div class="menu-item px-3">
                                <a class="menu-link px-3 view_items" data-settings-list-id="' .$lookups->id .'" data-bs-toggle="modal" data-bs-target="#kt_modal_view_items">'
                        . trans('admin.Edit') . '</a>
                             </div>';
                }
                    $actions .= '<div class="menu-item px-3">
                            <a class="menu-link px-3 add-sub-item"
                               data-parent-id="' . $lookups->id . '"
                               data-parent-name="' . $lookups->{'name_' . app()->getLocale()} . '"
                               data-master-key="' . $lookups->master_key . '"
                               data-bs-toggle="modal"
                               data-bs-target="#kt_modal_add_sub_item">
                                <i class="bi bi-plus-circle fs-4 me-2"></i>'
                        . trans('admin.Add Sub Item') . '</a>
                         </div>';

                if (auth()->user()->can('Delete List')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-land-btn"  data-land-id="' . $lookups->id . '">'
                        . trans('admin.Delete') . '</a>
                             </div>';

                }


                $actions .= '</div></div>';

                return $actions;
            })
            ->rawColumns(['list_name','item_name','status', 'actions'])
            ->make(true);

    }
}
