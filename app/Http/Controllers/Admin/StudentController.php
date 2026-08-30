<?php

namespace App\Http\Controllers\Admin;

use App\Events\MyCustomEvent;
use App\Http\Controllers\Controller;
use App\Mail\SendGenericMail;
use App\Models\Attachments;
use App\Models\Investors;
use App\Models\Lookups;
use App\Models\Settings;
use App\Models\Student;
use App\Models\StudentData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;
use Pusher\Pusher;
use Vtiful\Kernel\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Student create')->only('add','store');
        $this->middleware('can:Student view.blade.php')->only('view.blade.php');
        $this->middleware('can:Legal Accreditation of the Land')->only('approval_legal_ownership');
    }
    public function index()
    {
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        return view('admin.Students.list',$data);
    }
    public function add(){
        $data['investors'] = Student::query()->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data['settings'] = Settings::query()->find(1);

        return view('admin.Students.addStudent',$data);
    }
    public function edit($id){

        $data['student'] = Student::query()->find($id);
        $data['investors'] = Student::query()->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data['settings'] = Settings::query()->find(1);

        return view('admin.Students.editStudent',$data);

    }
    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validated = $request->validate([
                'student_id' => 'required|string|max:9|unique:students,student_id',
                'first_name' => 'required|string|max:50',
                'father_name' => 'required|string|max:50',
                'grandfather_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'gender' => 'required|in:male,female',
                'birth_date' => 'required|date',
                'address' => 'nullable|string',
                'mobile' => 'required|string|max:10',
                'alternate_mobile' => 'nullable|string|max:10',
                'health_status' => 'required|in:healthy,special_needs,chronic_disease',
                'parent_id' => 'required|string|max:9',
                'parent_name' => 'required|string|max:100',
                'initiative_id' => 'nullable|integer|exists:initiatives,id',
                'year_id' => 'nullable|integer|exists:years,id',
                'section_id' => 'nullable|integer|exists:sections,id',
                'notes' => 'nullable|string',
                'yearly_income' => 'nullable|numeric|min:0',
                'age_group' => 'required|exists:lookups,id',
                'class' => 'required|exists:lookups,id',
                'orphan_status' => 'required|in:not_an_orphan,father_is_an_orphan,mother_is_an_orphan,both_mother_and_father_are_orphans',
                'citizenship_status' => 'required|in:citizen,refugee',
            ]);

            // إنشاء الطالب
            $student = new Student();
            $student->student_id = $request->student_id;
            $student->first_name = $request->first_name;
            $student->father_name = $request->father_name;
            $student->grandfather_name = $request->grandfather_name;
            $student->last_name = $request->last_name;
            $student->gender = $request->gender;
            $student->birth_date = $request->birth_date;
            $student->address = $request->address;
            $student->mobile = $request->mobile;
            $student->alternate_mobile = $request->alternate_mobile;
            $student->health_status = $request->health_status;
            $student->parent_id = $request->parent_id;
            $student->parent_name = $request->parent_name;
            $student->study_start_date = now();
            $student->initiative_id = $request->initiative_id;
            $student->year_id = $request->year_id;
            $student->section_id = $request->section_id;
            $student->notes = $request->notes;
            $student->yearly_income = $request->yearly_income;
            $student->age_group = $request->age_group;
            $student->orphan_status = $request->orphan_status;
            $student->health_status_description = $request->health_status_description;
            $student->class = $request->class;
            $student->citizenship_status = $request->citizenship_status;

            // القيم الافتراضية
            $student->status_cd = 1; // نشط
            $student->profile_status_cd = 1; // مكتمل
            $student->terms_accepted = $request->terms_accepted ?? false;
            $student->balance = 0;

            // معالجة الصورة الشخصية (avatar)
            if ($request->hasFile('student_avatar')) {
                $image = $request->file('student_avatar');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/students/avatars'), $imageName);
                $student->student_avatar = 'uploads/students/avatars/' . $imageName;
            }

            $student->save();

            // تسجيل النشاط
            \Log::info('تم إضافة طالب جديد', [
                'student_id' => $student->student_id,
                'student_name' => $student->first_name . ' ' . $student->father_name,
                'added_by' => auth()->user()->id ?? null
            ]);

            // التحقق من نوع الطلب (AJAX أم عادي)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => __('admin.Student added successfully'),
                    'data' => $student,
                    'redirect' => route('student.index')
                ], 200);
            }

            // للطلبات العادية
            return redirect()->route('student.index')
                ->with('success', __('admin.Student added successfully'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            // للطلبات AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'فشل التحقق من البيانات',
                    'errors' => $e->errors()
                ], 422);
            }

            // للطلبات العادية
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            // تسجيل الخطأ للتصحيح
            \Log::error('Error storing student: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token', 'password'])
            ]);

            // للطلبات AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('admin.Something went wrong'),
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            // للطلبات العادية
            return redirect()->back()
                ->with('error', __('admin.Something went wrong') . ': ' . $e->getMessage())
                ->withInput();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // التحقق من صحة البيانات مع استثناء السجل الحالي
            $validated = $request->validate([
                'student_id' => 'required|string|max:9|unique:students,student_id,' . $id,
                'first_name' => 'required|string|max:50',
                'father_name' => 'required|string|max:50',
                'grandfather_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'gender' => 'required|in:male,female',
                'birth_date' => 'required|date',
                'address' => 'nullable|string',
                'mobile' => 'required|string|max:10|unique:students,mobile,' . $id,
                'alternate_mobile' => 'nullable|string|max:10',
                'health_status' => 'required|in:healthy,special_needs,chronic_disease',
                'parent_id' => 'required|string|max:9',
                'parent_name' => 'required|string|max:100',
                'initiative_id' => 'nullable|integer|exists:initiatives,id',
                'year_id' => 'nullable|integer|exists:years,id',
                'section_id' => 'nullable|integer|exists:sections,id',
                'notes' => 'nullable|string',
                'yearly_income' => 'nullable|numeric|min:0',
            ]);

            // استخدام findOrFail
            $student = Student::query()->findOrFail($id);

            // تحديث البيانات
            $student->update([
                'student_id' => $request->student_id,
                'first_name' => $request->first_name,
                'father_name' => $request->father_name,
                'grandfather_name' => $request->grandfather_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'alternate_mobile' => $request->alternate_mobile,
                'health_status' => $request->health_status,
                'parent_id' => $request->parent_id,
                'parent_name' => $request->parent_name,
                'study_start_date' => now(),
                'initiative_id' => $request->initiative_id,
                'year_id' => $request->year_id,
                'section_id' => $request->section_id,
                'notes' => $request->notes,
                'yearly_income' => $request->yearly_income,
                'age_group' => $request->age_group,
                'orphan_status' => $request->orphan_status,
                'health_status_description' => $request->health_status_description,
                'terms_accepted' => $request->terms_accepted ?? false,
                'class' => $request->class,
            ]);

            // معالجة الصور (تحسين)
            $this->handleFileUploads($request, $student);

            return response()->json([
                'status' => 'success',
                'message' => __('admin.Student updated successfully'),
                'data' => $student,
                'redirect' => route('student.index')
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error updating student: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => __('admin.Something went wrong'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

// دالة مساعدة لمعالجة الملفات
    private function handleFileUploads($request, $student)
    {
        // تعريف مسارات التخزين
        $uploadPaths = [
            'avatar' => 'uploads/students/avatars',
            'photo_personal_id' => 'uploads/students/ids',
            'photo_with_id' => 'uploads/students/with_ids'
        ];

        foreach ($uploadPaths as $field => $path) {
            if ($request->hasFile($field)) {
                // حذف الصورة القديمة إذا وجدت
                if ($student->$field && file_exists(public_path($student->$field))) {
                    unlink(public_path($student->$field));
                }

                $image = $request->file($field);
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path($path), $imageName);
                $student->$field = $path . '/' . $imageName;
            }
        }

        $student->save();
    }

    public function view($id){

        $data['student'] = Student::query()->find($id);
        $data['investors'] = Student::query()->get();
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data['settings'] = Settings::query()->find(1);

        return view('admin.Students.view',$data);

    }
    /**
     * جلب بيانات الطلاب مع الفلاتر
     */
    public function getStudents(Request $request)
    {
        $students = Student::query()->orderBy('id', 'desc');

        // ✅ الفلاتر الأساسية
        if ($request->filled('student_id')) {
            $students->where('student_id', $request->student_id);
        }
        if ($request->filled('first_name')) {
            $students->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->filled('last_name')) {
            $students->where('last_name', 'like', '%' . $request->last_name . '%');
        }
        if ($request->filled('mobile')) {
            $students->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        // ✅ الفلاتر الجديدة
        if ($request->filled('gender')) {
            $students->where('gender', $request->gender);
        }

        if ($request->filled('age_group')) {
            $students->where('age_group', $request->age_group);
        }

        if ($request->filled('class_id')) {
            $students->where('class', $request->class_id);
        }

        if ($request->filled('accreditation_status')) {
            $students->where('accreditation_status', $request->accreditation_status);
        }

        // الفلاتر الإضافية للموقع
        if ($request->filled('province_cd')) {
            $students->where('province_cd', $request->province_cd);
        }
        if ($request->filled('location_cities')) {
            $students->where('location_cities', $request->location_cities);
        }
        if ($request->filled('location_areas')) {
            $students->where('location_areas', $request->location_areas);
        }

        // فلترة تاريخ الميلاد
        if ($request->filled('birth_date_from')) {
            $students->where('birth_date', '>=', $request->birth_date_from);
        }
        if ($request->filled('birth_date_to')) {
            $students->where('birth_date', '<=', $request->birth_date_to);
        }

        return DataTables::of($students)
            ->addColumn('full_name', function ($student) {
                return $student->first_name . ' ' . ($student->last_name ?? '');
            })
            ->addColumn('birth_date', function ($student) {
                return $student->birth_date ? date('Y-m-d', strtotime($student->birth_date)) : '-';
            })
            ->addColumn('mobile', function ($student) {
                return $student->mobile ?? '-';
            })
            ->addColumn('actions', function ($student) {
                $actions = '<div class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-info btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        ' . trans('admin.Actions') . '
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                if (auth()->user()->can('Student view.blade.php')) {
                    $actions .= '<div class="menu-item px-3">
                            <a href="' . url("/students/view.blade.php-student/{$student->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                         </div>';
                }

                if (auth()->user()->can('Student edit')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/students/edit-student/{$student->id}") . '" class="menu-link px-3">'
                        . trans('admin.Edit') . '</a>
                             </div>';
                }

                if (auth()->user()->can('Student delete')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-student-btn" data-student-id="' . $student->id . '">'
                        . trans('admin.Delete') . '</a>
                             </div>';
                }

                $actions .= '</div></div>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * تصدير بيانات الطلاب مع تطبيق الفلاتر
     */
    public function exportStudents(Request $request)
    {
        try {
            // ✅ جلب البيانات مع تطبيق الفلاتر
            $students = Student::query()->orderBy('id', 'desc');

            // تطبيق جميع الفلاتر نفسها المستخدمة في getStudents
            if ($request->filled('filters.student_id')) {
                $students->where('student_id', $request->filters['student_id']);
            }
            if ($request->filled('filters.first_name')) {
                $students->where('first_name', 'like', '%' . $request->filters['first_name'] . '%');
            }
            if ($request->filled('filters.last_name')) {
                $students->where('last_name', 'like', '%' . $request->filters['last_name'] . '%');
            }
            if ($request->filled('filters.mobile')) {
                $students->where('mobile', 'like', '%' . $request->filters['mobile'] . '%');
            }
            if ($request->filled('filters.gender')) {
                $students->where('gender', $request->filters['gender']);
            }
            if ($request->filled('filters.age_group')) {
                $students->where('age_group', $request->filters['age_group']);
            }
            if ($request->filled('filters.class_id')) {
                $students->where('class', $request->filters['class_id']);
            }
            if ($request->filled('filters.accreditation_status')) {
                $students->where('accreditation_status', $request->filters['accreditation_status']);
            }
            if ($request->filled('filters.birth_date_from')) {
                $students->where('birth_date', '>=', $request->filters['birth_date_from']);
            }
            if ($request->filled('filters.birth_date_to')) {
                $students->where('birth_date', '<=', $request->filters['birth_date_to']);
            }

            $studentsData = $students->get();

            $exportType = $request->type ?? 'excel';

            if ($exportType === 'pdf') {
                return $this->exportPDF($studentsData);
            } else {
                return $this->exportHTMLExcel($studentsData);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ في عملية التصدير: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تصدير إلى Excel باستخدام HTML
     */
    private function exportHTMLExcel($students)
    {
        $filename = 'students_' . date('Y-m-d_H-i-s') . '.xls';

        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
                  xmlns:x="urn:schemas-microsoft-com:office:excel"
                  xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <!--[if gte mso 9]>
                    <xml>
                        <x:ExcelWorkbook>
                            <x:ExcelWorksheets>
                                <x:ExcelWorksheet>
                                    <x:Name>Students</x:Name>
                                    <x:WorksheetOptions>
                                        <x:DisplayGridlines/>
                                    </x:WorksheetOptions>
                                </x:ExcelWorksheet>
                            </x:ExcelWorksheets>
                        </x:ExcelWorkbook>
                    </xml>
                    <![endif]-->
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            direction: rtl;
                            font-family: Arial, sans-serif;
                        }
                        th {
                            background-color: #4a90d9;
                            color: white;
                            padding: 10px;
                            border: 1px solid #ddd;
                            font-weight: bold;
                        }
                        td {
                            padding: 8px;
                            border: 1px solid #ddd;
                            text-align: center;
                        }
                        tr:nth-child(even) {
                            background-color: #f9f9f9;
                        }
                        .header {
                            text-align: center;
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class="header">قائمة الطلاب</div>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الطالب</th>
                                <th>الاسم الأول</th>
                                <th>اسم الأب</th>
                                <th>اسم الجد</th>
                                <th>اسم العائلة</th>
                                <th>الجنس</th>
                                <th>تاريخ الميلاد</th>
                                <th>رقم الجوال</th>
                                <th>الصف</th>
                                <th>البريد الإلكتروني</th>
                                <th>المحافظة</th>
                                <th>المدينة</th>
                                <th>المنطقة</th>
                                <th>حالة الاعتماد</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($students as $index => $student) {
            $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . $student->student_id . '</td>
                    <td>' . $student->first_name . '</td>
                    <td>' . ($student->father_name ?? '') . '</td>
                    <td>' . ($student->grandfather_name ?? '') . '</td>
                    <td>' . ($student->last_name ?? '') . '</td>
                    <td>' . ($student->gender === 'male' ? 'ذكر' : 'أنثى') . '</td>
                    <td>' . ($student->birth_date ? date('Y-m-d', strtotime($student->birth_date)) : '') . '</td>
                    <td>' . ($student->mobile ?? '') . '</td>
                    <td>' . ($student->class ?? '') . '</td>
                    <td>' . ($student->email ?? '') . '</td>
                    <td>' . ($student->province_cd ?? '') . '</td>
                    <td>' . ($student->location_cities ?? '') . '</td>
                    <td>' . ($student->location_areas ?? '') . '</td>
                    <td>' . $this->getAccreditationStatusText($student->accreditation_status) . '</td>
                </tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }
    private function exportPDF($students)
    {
        $data = [
            'students' => $students,
            'title' => 'قائمة الطلاب',
            'date' => date('Y-m-d H:i:s')
        ];

        $html = view('admin.exports.students_pdf', $data)->render();

        $options = new Options();
        $options->set('defaultFont', 'Cairo');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'students_' . date('Y-m-d_H-i-s') . '.pdf';

        return $dompdf->download($filename);
    }

    /**
     * الحصول على نص حالة الاعتماد
     */
    private function getAccreditationStatusText($status)
    {
        $statuses = [
            'approved' => 'معتمد',
            'pending' => 'قيد الانتظار',
            'rejected' => 'مرفوض'
        ];
        return $statuses[$status] ?? $status;
    }

    /**
     * البحث عن بيانات الطالب
     */
    public function searchStudentData($student_id)
    {
        try {
            $studentData = StudentData::where('student_id', $student_id)->first();

            if ($studentData) {
                return response()->json([
                    'status' => 'found',
                    'data' => [
                        'first_name' => $studentData->first_name,
                        'father_name' => $studentData->father_name,
                        'grandfather_name' => $studentData->grandfather_name,
                        'last_name' => $studentData->last_name,
                        'gender' => $studentData->gender,
                        'birth_date' => $studentData->birth_date,
                        'health_status' => $studentData->health_status,
                        'parent_id' => $studentData->parent_id,
                        'parent_name' => $studentData->parent_name,
                        'mobile' => $studentData->mobile,
                        'alternate_mobile' => $studentData->alternate_mobile,
                        'address' => $studentData->address ?? '',
                        'notes' => $studentData->notes ?? '',
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'not_found',
                    'message' => __('admin.Student not found in database')
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('admin.Something went wrong'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getClassesByAgeGroup(Request $request)
    {
        $ageGroupId = $request->age_group_id;

        $classes = \App\Models\Lookups::where('master_key', 'age_group')
            ->where('parent_id', $ageGroupId)
            ->where('status', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }

    public function registered_by_website(Request $request)
    {
        $data["provinces"] = Lookups::query()->where([
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        $data["ownership_type"] = Lookups::query()->where([
            "master_key" => "ownership_type_cd"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();
        return view('admin.Students.registered_by_website',$data);
    }
    public function getStudentsRegisteredByWebsite(Request $request)
    {
        $students = Student::query()->orderBy('id', 'desc');

        // ✅ الفلاتر الأساسية
        if ($request->filled('student_id')) {
            $students->where('student_id', $request->student_id);
        }
        if ($request->filled('first_name')) {
            $students->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->filled('last_name')) {
            $students->where('last_name', 'like', '%' . $request->last_name . '%');
        }
        if ($request->filled('mobile')) {
            $students->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        // ✅ الفلاتر الجديدة
        if ($request->filled('gender')) {
            $students->where('gender', $request->gender);
        }

        if ($request->filled('age_group')) {
            $students->where('age_group', $request->age_group);
        }

        if ($request->filled('class_id')) {
            $students->where('class', $request->class_id);
        }

        if ($request->filled('accreditation_status')) {
            $students->where('accreditation_status', $request->accreditation_status);
        }

        // الفلاتر الإضافية للموقع
        if ($request->filled('province_cd')) {
            $students->where('province_cd', $request->province_cd);
        }
        if ($request->filled('location_cities')) {
            $students->where('location_cities', $request->location_cities);
        }
        if ($request->filled('location_areas')) {
            $students->where('location_areas', $request->location_areas);
        }

        // فلترة تاريخ الميلاد
        if ($request->filled('birth_date_from')) {
            $students->where('birth_date', '>=', $request->birth_date_from);
        }
        if ($request->filled('birth_date_to')) {
            $students->where('birth_date', '<=', $request->birth_date_to);
        }

        return DataTables::of($students)
            ->addColumn('full_name', function ($student) {
                return $student->first_name . ' ' . ($student->last_name ?? '');
            })
            ->addColumn('birth_date', function ($student) {
                return $student->birth_date ? date('Y-m-d', strtotime($student->birth_date)) : '-';
            })
            ->addColumn('mobile', function ($student) {
                return $student->mobile ?? '-';
            })
            ->addColumn('actions', function ($student) {
                $actions = '<div class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-info btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        ' . trans('admin.Actions') . '
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">';

                if (auth()->user()->can('Student view.blade.php')) {
                    $actions .= '<div class="menu-item px-3">
                            <a href="' . url("/students/view.blade.php-student/{$student->id}") . '" class="menu-link px-3">'
                        . trans('admin.View') . '</a>
                         </div>';
                }

                if (auth()->user()->can('Student edit')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="' . url("/students/edit-student/{$student->id}") . '" class="menu-link px-3">'
                        . trans('admin.Edit') . '</a>
                             </div>';
                }

                if (auth()->user()->can('Student delete')) {
                    $actions .= '<div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-student-btn" data-student-id="' . $student->id . '">'
                        . trans('admin.Delete') . '</a>
                             </div>';
                }

                $actions .= '</div></div>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


}
