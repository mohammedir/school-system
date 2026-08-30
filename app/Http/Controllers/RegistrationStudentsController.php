<?php

namespace App\Http\Controllers;

use App\Models\RegistrationStudents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegistrationStudentsController extends Controller
{
    //
    public function storeStudent(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validator = Validator::make($request->all(), [
                'student_id_number' => [
                    'required',
                    'string',
                    'max:20',
                    function ($attribute, $value, $fail) {
                        // التحقق في جدول registrations_students
                        $existsInRegistrations = \App\Models\RegistrationStudents::where('student_id_number', $value)->exists();

                        // التحقق في جدول students
                        $existsInStudents = \App\Models\Student::where('student_id', $value)->exists();

                        // إذا كان موجوداً في أي من الجدولين
                        if ($existsInRegistrations || $existsInStudents) {
                            $fail('رقم الهوية مسجل مسبقاً في النظام.');
                        }
                    },
                ],
                'student_full_name' => 'required|string|max:255',
                'birth_date' => 'required|date|before:today',
                'address' => 'required|string|max:500',
                'age_group_id' => 'required|exists:lookups,id',
                'class_id' => 'required|exists:lookups,id',
                'guardian_name' => 'required|string|max:255',
                'guardian_id_number' => 'required|string|max:20',
                'phone_number' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
                'transfer_notice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'additional_notes' => 'nullable|string|max:1000',
            ], [
                'student_id_number.required' => 'رقم هوية الطالب مطلوب',
                'student_full_name.required' => 'اسم الطالب مطلوب',
                'birth_date.required' => 'تاريخ الميلاد مطلوب',
                'birth_date.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم',
                'address.required' => 'عنوان السكن مطلوب',
                'age_group_id.required' => 'المرحلة الدراسية مطلوبة',
                'class_id.required' => 'الفصل الدراسي مطلوب',
                'guardian_name.required' => 'اسم ولي الأمر مطلوب',
                'guardian_id_number.required' => 'رقم هوية ولي الأمر مطلوب',
                'phone_number.required' => 'رقم الهاتف مطلوب',
                'phone_number.regex' => 'رقم الهاتف غير صحيح',
                'transfer_notice.file' => 'الملف غير صحيح',
                'transfer_notice.mimes' => 'الملف يجب أن يكون من نوع PDF, JPG, JPEG, PNG',
                'transfer_notice.max' => 'حجم الملف يجب أن لا يتجاوز 2 ميجابايت',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // معالجة رفع الملف
            $transferNoticePath = null;
            if ($request->hasFile('transfer_notice')) {
                try {
                    $file = $request->file('transfer_notice');

                    // التحقق من صحة الملف
                    if (!$file->isValid()) {
                        Log::error('الملف غير صحيح: ' . $file->getErrorMessage());
                        return response()->json([
                            'success' => false,
                            'message' => 'الملف غير صحيح'
                        ], 400);
                    }

                    // إنشاء اسم فريد للملف
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // ✅ التخزين مباشرة في public/uploads
                    $destinationPath = public_path('uploads/transfer_notices');

                    // إنشاء المجلد إذا لم يكن موجوداً
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }

                    // نقل الملف إلى المجلد
                    $file->move($destinationPath, $fileName);

                    // حفظ المسار النسبي في قاعدة البيانات
                    $transferNoticePath = 'uploads/transfer_notices/' . $fileName;

                    Log::info('تم تخزين الملف بنجاح في: ' . $transferNoticePath);

                } catch (\Exception $e) {
                    Log::error('خطأ في رفع الملف: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'حدث خطأ أثناء رفع الملف: ' . $e->getMessage()
                    ], 500);
                }
            }

            // حفظ البيانات
            $registration = RegistrationStudents::create([
                'student_id_number' => $request->student_id_number,
                'student_full_name' => $request->student_full_name,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'age_group_id' => $request->age_group_id,
                'class_id' => $request->class_id,
                'guardian_name' => $request->guardian_name,
                'guardian_id_number' => $request->guardian_id_number,
                'phone_number' => $request->phone_number,
                'transfer_notice' => $transferNoticePath,
                'additional_notes' => $request->additional_notes,
                'status' => 'pending',
            ]);

            // تسجيل النشاط
            Log::info('تم تسجيل طالب جديد', [
                'registration_id' => $registration->id,
                'student_name' => $registration->student_full_name,
                'phone' => $registration->phone_number,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم استلام طلب التسجيل بنجاح! سنتواصل معك قريباً.',
                'data' => $registration
            ], 201);

        } catch (\Exception $e) {
            Log::error('خطأ في تسجيل الطالب: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
