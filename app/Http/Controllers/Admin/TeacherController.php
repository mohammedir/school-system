<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                                <a href="' . url("admin/teachers/editTeachers/{$teacher->id}") . '" class="menu-link px-3">'
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

    public function addTeachers(Request $request)
    {
        return view('admin.Teachers.add');

    }
    public function storeTeachers(Request $request)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string|max:50|unique:teachers,phone_number',
            'national_id' => 'nullable|string|max:50|unique:teachers,national_id',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',

            'address' => 'nullable|string|max:255',
            'province_id' => 'nullable|exists:lookups,id',
            'city_id' => 'nullable|exists:lookups,id',
            'district_id' => 'nullable|exists:lookups,id',

            'age_group_id' => 'nullable|exists:lookups,id',
            'specializations' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'qualifications' => 'nullable|string',
            'certificates' => 'nullable|string',
            'previous_experience' => 'nullable|string',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'certificates_file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'id_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'certificate_good_conduct' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            'status' => 'required|in:pending,active,inactive,suspended',
            'availability' => 'nullable|in:full_time,part_time,freelance',
            'notes' => 'nullable|string',
        ]);

        // تشفير كلمة المرور
        $validated['password'] = Hash::make($validated['password']);

        // مجلد رفع ملفات المعلمين
        $uploadPath = public_path('uploads/teachers');

        // إنشاء المجلد إذا لم يكن موجودًا
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        /*
        |--------------------------------------------------------------------------
        | صورة المدرس
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {

            $profileName = time() . '_profile.' .
                $request->file('profile_image')->getClientOriginalExtension();

            $request->file('profile_image')->move($uploadPath.'/profiles/', $profileName);

            $validated['profile_image'] = 'uploads/teachers/profiles/'.$profileName;
        }

        /*
        |--------------------------------------------------------------------------
        | السيرة الذاتية
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('cv_file')) {

            $cvName = time() . '_cv.' .
                $request->file('cv_file')->getClientOriginalExtension();

            $request->file('cv_file')->move($uploadPath, $cvName);

            $validated['cv_file'] = $cvName;
        }

        /*
        |--------------------------------------------------------------------------
        | ملف الشهادات
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('certificates_file')) {

            $certificatesName = time() . '_certificates.' .
                $request->file('certificates_file')->getClientOriginalExtension();

            $request->file('certificates_file')->move($uploadPath, $certificatesName);

            $validated['certificates_file'] = $certificatesName;
        }

        /*
        |--------------------------------------------------------------------------
        | صورة الهوية
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('id_photo')) {

            $idPhotoName = time() . '_id.' .
                $request->file('id_photo')->getClientOriginalExtension();

            $request->file('id_photo')->move($uploadPath, $idPhotoName);

            $validated['id_photo'] = $idPhotoName;
        }

        /*
        |--------------------------------------------------------------------------
        | شهادة حسن السيرة والسلوك
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('certificate_good_conduct')) {

            $goodConductName = time() . '_good_conduct.' .
                $request->file('certificate_good_conduct')->getClientOriginalExtension();

            $request->file('certificate_good_conduct')->move($uploadPath, $goodConductName);

            $validated['certificate_good_conduct'] = $goodConductName;
        }

        // حفظ المدرس
        Teacher::create($validated);

        return redirect()
            ->route('admin.teachers.list')
            ->with('success', 'تم إضافة المدرس بنجاح');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);

        return view('admin.Teachers.edit', compact(
            'teacher',
        ));
    }
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,

            'phone_number' => 'required|string|max:50|unique:teachers,phone_number,' . $teacher->id,

            'national_id' => 'nullable|string|max:50|unique:teachers,national_id,' . $teacher->id,

            'birth_date' => 'nullable|date',

            'gender' => 'nullable|in:male,female',

            'address' => 'nullable|string|max:255',


            'age_group_id' => 'nullable|exists:lookups,id',

            'specializations' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'qualifications' => 'nullable|string',
            'certificates' => 'nullable|string',
            'previous_experience' => 'nullable|string',

            'password' => 'nullable|string|min:6|confirmed',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:5120',

            'certificates_file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            'id_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'certificate_good_conduct' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',

            'status' => 'required|in:pending,active,inactive,suspended',

            'availability' => 'nullable|in:full_time,part_time,freelance',

            'notes' => 'nullable|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | كلمة المرور
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $validated['password'] = Hash::make($request->password);

        } else {

            // عدم تغيير كلمة المرور الحالية
            unset($validated['password']);

        }


        /*
        |--------------------------------------------------------------------------
        | مجلد رفع الملفات
        |--------------------------------------------------------------------------
        */

        $uploadPath = public_path('uploads/teachers');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }


        /*
        |--------------------------------------------------------------------------
        | صورة المدرس
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {

            // حذف الصورة القديمة
            if ($teacher->profile_image) {

                $oldFile = $uploadPath . '/' . $teacher->profile_image;

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('profile_image');

            $fileName = time() . '_profile.' .
                $file->getClientOriginalExtension();

            $file->move($uploadPath.'/profiles/', $fileName);

            $validated['profile_image'] = 'uploads/teachers/profiles/'.$fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | السيرة الذاتية
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('cv_file')) {

            if ($teacher->cv_file) {

                $oldFile = $uploadPath . '/' . $teacher->cv_file;

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('cv_file');

            $fileName = time() . '_cv.' .
                $file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $validated['cv_file'] = $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | ملف الشهادات
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('certificates_file')) {

            if ($teacher->certificates_file) {

                $oldFile = $uploadPath . '/' . $teacher->certificates_file;

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('certificates_file');

            $fileName = time() . '_certificates.' .
                $file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $validated['certificates_file'] = $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | صورة الهوية
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('id_photo')) {

            if ($teacher->id_photo) {

                $oldFile = $uploadPath . '/' . $teacher->id_photo;

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('id_photo');

            $fileName = time() . '_id.' .
                $file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $validated['id_photo'] = $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | شهادة حسن السيرة والسلوك
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('certificate_good_conduct')) {

            if ($teacher->certificate_good_conduct) {

                $oldFile = $uploadPath . '/' . $teacher->certificate_good_conduct;

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('certificate_good_conduct');

            $fileName = time() . '_good_conduct.' .
                $file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $validated['certificate_good_conduct'] = $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | تحديث بيانات المدرس
        |--------------------------------------------------------------------------
        */

        $teacher->update($validated);


        return redirect()
            ->route('admin.teachers.list')
            ->with('success', 'تم تعديل بيانات المدرس بنجاح');
    }
}
