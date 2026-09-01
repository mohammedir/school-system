<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Lookups;
use App\Models\RegistrationStudents;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SitesController extends Controller
{
    //
    public function complaints(){
      return view('admin.SitesManagement.complaints');
    }
    public function registrations_students()
    {
        return view('admin.SitesManagement.registrations_students');
    }

    /**
     * جلب بيانات الشكاوى للـ DataTable
     */
    public function getComplaintsData(Request $request)
    {
        $query = Complaint::query();

        // تطبيق الفلاتر
        if ($request->complainant_name) {
            $query->where('complainant_name', 'like', '%' . $request->complainant_name . '%');
        }

        if ($request->phone_number) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('type_html', function ($complaint) {
                $badgeClass = $complaint->type == 'complaint' ? 'danger' :
                    ($complaint->type == 'suggestion' ? 'info' : 'warning');
                $typeNames = [
                    'complaint' => 'شكوى',
                    'suggestion' => 'اقتراح',
                    'inquiry' => 'استفسار'
                ];
                return '<span class="badge badge-' . $badgeClass . '">' . $typeNames[$complaint->type] . '</span>';
            })
            ->addColumn('status_html', function ($complaint) {
                $badgeClass = $complaint->status == 'pending' ? 'warning' :
                    ($complaint->status == 'in_progress' ? 'info' :
                        ($complaint->status == 'resolved' ? 'success' : 'danger'));
                $statusNames = [
                    'pending' => 'قيد الانتظار',
                    'in_progress' => 'قيد المعالجة',
                    'resolved' => 'تم الحل',
                    'rejected' => 'مرفوض'
                ];
                return '<span class="badge badge-' . $badgeClass . '">' . $statusNames[$complaint->status] . '</span>';
            })
            ->addColumn('details_short', function ($complaint) {
                return strlen($complaint->details) > 50 ?
                    substr($complaint->details, 0, 50) . '...' :
                    $complaint->details;
            })
            ->addColumn('actions', function ($complaint) {
                return '
                    <div class="d-flex justify-content-end flex-shrink-0">
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 view.blade.php-complaint-btn" data-id="' . $complaint->id . '" data-bs-toggle="tooltip" title="عرض التفاصيل">
                            <i class="bi bi-eye fs-3"></i>
                        </a>
                        <select class="form-select form-select-sm complaint-status-select" data-id="' . $complaint->id . '" style="width: 130px; margin-right: 5px;">
                            <option value="pending" ' . ($complaint->status == 'pending' ? 'selected' : '') . '>قيد الانتظار</option>
                            <option value="in_progress" ' . ($complaint->status == 'in_progress' ? 'selected' : '') . '>قيد المعالجة</option>
                            <option value="resolved" ' . ($complaint->status == 'resolved' ? 'selected' : '') . '>تم الحل</option>
                            <option value="rejected" ' . ($complaint->status == 'rejected' ? 'selected' : '') . '>مرفوض</option>
                        </select>
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-complaint-btn" data-id="' . $complaint->id . '" data-name="' . $complaint->complainant_name . '" data-bs-toggle="tooltip" title="حذف">
                            <i class="bi bi-trash fs-3"></i>
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['type_html', 'status_html', 'actions'])
            ->make(true);
    }
    public function getRegistrationsStudentsData(Request $request)
    {
        $query = RegistrationStudents::with(['ageGroup', 'class']);

        // فلترة حسب الاسم
        if ($request->filled('student_full_name')) {
            $query->where('student_full_name', 'like', '%' . $request->student_full_name . '%');
        }

        // فلترة حسب رقم الهوية
        if ($request->filled('student_id_number')) {
            $query->where('student_id_number', 'like', '%' . $request->student_id_number . '%');
        }

        // فلترة حسب رقم الهاتف
        if ($request->filled('phone_number')) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }

        // فلترة حسب المرحلة
        if ($request->filled('age_group_id')) {
            $query->where('age_group_id', $request->age_group_id);
        }

        // فلترة حسب الفصل
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('age_group_name', function ($row) {
                return $row->ageGroup ? $row->ageGroup->name_ar : '-';
            })
            ->addColumn('class_name', function ($row) {
                return $row->class ? $row->class->name_ar : '-';
            })
            ->addColumn('status_badge', function ($row) {
                $badges = [
                    'pending' => '<span class="badge badge-warning">قيد الانتظار</span>',
                    'approved' => '<span class="badge badge-success">مقبول</span>',
                    'rejected' => '<span class="badge badge-danger">مرفوض</span>',
                    'completed' => '<span class="badge badge-info">مكتمل</span>',
                ];
                return $badges[$row->status] ?? '<span class="badge badge-secondary">غير معروف</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="javascript:void(0)" class="btn btn-sm btn-light-info view.blade.php-student-btn" data-id="' . $row->id . '">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="" class="btn btn-sm btn-light-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-light-danger delete-student-btn" data-id="' . $row->id . '">
                        <i class="bi bi-trash"></i>
                    </a>
                ';
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }
    /**
     * عرض تفاصيل شكوى محددة
     */
    public function getComplaintDetails($id)
    {
        $complaint = Complaint::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $complaint->id,
                'complainant_name' => $complaint->complainant_name,
                'phone_number' => $complaint->phone_number,
                'type' => $complaint->type,
                'type_name' => $complaint->type_name,
                'status' => $complaint->status,
                'status_name' => $complaint->status_name,
                'details' => $complaint->details,
                'admin_reply' => $complaint->admin_reply,
                'created_at' => $complaint->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    public function getRegistrationsStudentsDetails($id)
    {
        try {
            $student = RegistrationStudents::with(['ageGroup', 'class'])->findOrFail($id);

            // تحويل المسار النسبي للملف إلى رابط كامل
            if ($student->transfer_notice) {
                $student->transfer_notice = asset($student->transfer_notice);
            }

            $student->age_group_name = $student->ageGroup ? $student->ageGroup->name_ar : '-';
            $student->class_name = $student->class ? $student->class->name_ar : '-';

            $badges = [
                'pending' => '<span class="badge badge-warning">قيد الانتظار</span>',
                'approved' => '<span class="badge badge-success">مقبول</span>',
                'rejected' => '<span class="badge badge-danger">مرفوض</span>',
                'completed' => '<span class="badge badge-info">مكتمل</span>',
            ];
            $student->status_badge = $badges[$student->status] ?? '<span class="badge badge-secondary">غير معروف</span>';

            return response()->json([
                'success' => true,
                'data' => $student
            ]);
        } catch (\Exception $e) {
            Log::error('خطأ في عرض الطالب: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في عرض التفاصيل'
            ], 500);
        }
    }


    public function updateComplaintStatus(Request $request, $id)
    {
        try {
            // التحقق من صحة البيانات
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,in_progress,resolved,rejected',
                'admin_reply' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'بيانات غير صحيحة'
                ], 422);
            }

            // البحث عن الشكوى
            $complaint = Complaint::find($id);

            if (!$complaint) {
                return response()->json([
                    'success' => false,
                    'message' => 'الشكوى غير موجودة'
                ], 404);
            }

            // تحديث الحالة
            $complaint->status = $request->status;

            // إذا كان هناك رد إداري
            if ($request->has('admin_reply')) {
                $complaint->admin_reply = $request->admin_reply;
            }

            $complaint->save();

            // تسجيل النشاط في الـ Log (اختياري)
            Log::info('تم تحديث حالة الشكوى', [
                'complaint_id' => $complaint->id,
                'new_status' => $request->status,
                'updated_by' => auth()->user()->id ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الشكوى بنجاح',
                'data' => [
                    'id' => $complaint->id,
                    'status' => $complaint->status,
                    'status_name' => $complaint->status_name,
                    'admin_reply' => $complaint->admin_reply,
                    'updated_at' => $complaint->updated_at->format('Y-m-d H:i:s')
                ]
            ], 200);

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('خطأ في تحديث حالة الشكوى', [
                'complaint_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sitsManagement(Request $request)
    {
        $data['site_settings'] = SiteSetting::firstOrCreate(['id' => 1]);
        return view('admin.SitesManagement.site_mangement', $data);

    }
    public function sitsManagementUpdate(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'site_name'       => 'required|string|max:255',
            'contact_email'   => 'nullable|email|max:255',
            'site_logo'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'principal_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // جلب سجل الإعدادات الأساسي
        $settings = SiteSetting::firstOrCreate(['id' => 1]);

        // أخذ جميع النصوص المدخلة في Form
        $data = $request->except([
            '_token',
            '_method',
            'site_logo',
            'principal_image'
        ]);

        /*
        |--------------------------------------------------------------------------
        | مجلد الصور
        |--------------------------------------------------------------------------
        */
        $settings->site_name = $request->site_name;
        $settings->hero_title = $request->hero_title;
        $settings->hero_subtitle = $request->hero_subtitle;
        $settings->school_vision = $request->school_vision;
        $settings->school_mission = $request->school_mission;
        $settings->principal_name = $request->principal_name;
        $settings->contact_phone = $request->contact_phone;
        $settings->contact_address = $request->contact_address;
        $settings->principal_speech = $request->principal_speech;
        $settings->social_facebook = $request->social_facebook;
        $settings->social_instagram = $request->social_instagram;

        $uploadPath = public_path('uploads/site');

        // إنشاء المجلد إذا لم يكن موجوداً
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        /*
        |--------------------------------------------------------------------------
        | رفع شعار الموقع
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('site_logo')) {

            // حذف الصورة القديمة
            if ($settings->site_logo) {

                $oldLogo = public_path('uploads/site/' . $settings->site_logo);

                if (file_exists($oldLogo)) {
                    unlink($oldLogo);
                }
            }

            // إنشاء اسم جديد للصورة
            $logoName = time() . '_logo.' .
                $request->file('site_logo')->getClientOriginalExtension();

            // نقل الصورة إلى public/uploads/site
            $request->file('site_logo')->move($uploadPath, $logoName);

            // حفظ اسم الصورة فقط في قاعدة البيانات
            $data['site_logo'] = $logoName;
        }

        /*
        |--------------------------------------------------------------------------
        | رفع صورة المديرة
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('principal_image')) {

            // حذف الصورة القديمة
            if ($settings->principal_image) {

                $oldPrincipal = public_path(
                    'uploads/site/' . $settings->principal_image
                );

                if (file_exists($oldPrincipal)) {
                    unlink($oldPrincipal);
                }
            }

            // إنشاء اسم جديد للصورة
            $principalName = time() . '_principal.' .
                $request->file('principal_image')->getClientOriginalExtension();

            // نقل الصورة
            $request->file('principal_image')->move(
                $uploadPath,
                $principalName
            );

            // حفظ اسم الصورة فقط
            $data['principal_image'] = $principalName;
        }

        /*
        |--------------------------------------------------------------------------
        | تحديث قاعدة البيانات
        |--------------------------------------------------------------------------
        */

        $settings->update($data);

        return redirect()
            ->back()
            ->with('success', 'تم تحديث كافة بيانات الموقع بنجاح');
    }

}
