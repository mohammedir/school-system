<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    //
    public function list()
    {

        return view('admin.Teachers.list');
    }
    public function viewTeacher($id)
    {
        $teacher= Teacher::query()->find($id);
        return view('admin.Teachers.view',compact('teacher'));
    }

    public function getTeachers(Request $request)
    {
        $teacher = Teacher::query()->orderBy('id', 'desc');


        // ✅ الفلاتر الأساسية
        if ($request->filled('id')) {
            $teacher->where('id', $request->id);
        }
        if ($request->filled('teacher_name')) {
            $teacher->where('teacher_name', 'like', '%' . $request->teacher_name . '%');
        }
        if ($request->filled('phone_number')) {
            $teacher->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }
        if ($request->filled('national_id')) {
            $teacher->where('national_id', $request->national_id);
        }

        return DataTables::of($teacher)
            ->addColumn('national_id', function ($teacher) {
                return ($teacher->national_id ?? '');
            })
            ->addColumn('teacher_name', function ($teacher) {
                return $teacher->teacher_name . ' ';
            })
            ->addColumn('birth_date', function ($teacher) {
                return $teacher->birth_date ?? '-';
            })
            ->addColumn('phone_number', function ($teacher) {
                return $teacher->phone_number ?? '-';
            })
            ->addColumn('actions', function ($teacher) {
                $actions = '<div class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-info btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        ' . trans('admin.Actions') . '
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                if (auth()->user()->can('Student view')) {
                    $actions .= '<div class="menu-item px-3">
                            <a href="' . url("admin/teachers/view-teacher/{$teacher->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                         </div>';
                }

                if (auth()->user()->can('Student edit')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/students/edit-student/{$teacher->id}") . '" class="menu-link px-3">'
                        . trans('admin.Edit') . '</a>
                             </div>';
                }

                if ($teacher->status == 'pending') {
                    // زر تفعيل مباشر للحالة pending
                    $actions .= '<div class="menu-item px-3">
                        <a href="#" class="menu-link px-3 activate-teacher-btn"
                           data-teacher-id="' . $teacher->id . '"
                           data-teacher-name="' . $teacher->teacher_name . '">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            تفعيل الحساب
                        </a>
                    </div>';
                } else {
                    // زر فتح مودال تغيير الحالة للحالات الأخرى
                    $actions .= '<div class="menu-item px-3">
                        <a href="#" class="menu-link px-3 change-status-btn"
                           data-bs-toggle="modal"
                           data-bs-target="#changeStatusModal"
                           data-teacher-id="' . $teacher->id . '"
                           data-teacher-name="' . $teacher->teacher_name . '"
                           data-current-status="' . $teacher->status . '">
                            <i class="fa fa-exchange-alt me-2"></i>
                            تغيير الحالة
                        </a>
                    </div>';
                }
                if (auth()->user()->can('Student delete')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-student-btn" data-student-id="' . $teacher->id . '">'
                        . trans('admin.Delete') . '</a>
                             </div>';
                }

                $actions .= '</div></div>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // دالة التفعيل المباشر للحالة pending
    public function activateTeacher($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);

            // التأكد من أن الحالة pending
            if ($teacher->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'يمكن تفعيل الحسابات التي بحالة "قيد الانتظار" فقط'
                ], 400);
            }

            $teacher->status = 'active';
            $teacher->save();

            Log::info('تم تفعيل حساب المدرس', [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->teacher_name,
                'changed_by' => auth()->user()->id ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تفعيل حساب المدرس بنجاح',
                'new_status' => 'active',
                'status_text' => 'مفعل'
            ]);

        } catch (\Exception $e) {
            Log::error('خطأ في تفعيل المدرس: ' . $e->getMessage(), [
                'teacher_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تفعيل الحساب: ' . $e->getMessage()
            ], 500);
        }
    }

// دالة تغيير الحالة من المودال
    public function changeStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive,suspended'
            ]);

            $teacher = Teacher::findOrFail($id);

            // منع تغيير الحالة لنفس الحالة الحالية
            if ($teacher->status === $request->status) {
                return response()->json([
                    'success' => false,
                    'message' => 'المدرس بالفعل في هذه الحالة'
                ], 400);
            }

            $oldStatus = $teacher->status;
            $teacher->status = $request->status;
            $teacher->save();

            // تسجيل الحدث
            Log::info('تم تغيير حالة المدرس', [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->teacher_name,
                'old_status' => $oldStatus,
                'new_status' => $teacher->status,
                'changed_by' => auth()->user()->id ?? null
            ]);

            // ترجمة الحالة
            $statusNames = [
                'active' => 'مفعل',
                'inactive' => 'غير مفعل',
                'suspended' => 'موقوف'
            ];

            return response()->json([
                'success' => true,
                'message' => 'تم تغيير حالة المدرس إلى ' . ($statusNames[$teacher->status] ?? $teacher->status) . ' بنجاح',
                'new_status' => $teacher->status,
                'status_text' => $statusNames[$teacher->status] ?? $teacher->status
            ]);

        } catch (\Exception $e) {
            Log::error('خطأ في تغيير حالة المدرس: ' . $e->getMessage(), [
                'teacher_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تغيير حالة الحساب: ' . $e->getMessage()
            ], 500);
        }
    }
}
