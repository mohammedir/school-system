<?php

namespace App\Http\Controllers\Teachers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendGenericMail;
use App\Models\Lookups;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $data["provinces"] = Lookups::query()
            ->where("master_key", "province")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();

        return view('teacher.auth.register', compact('data'));
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();

            // التحقق من صحة البيانات
            $validator = Validator::make($request->all(), [
                // المعلومات الأساسية
                'teacher_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:teachers,email',
                'phone_number' => 'required|string|max:20|unique:teachers,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                // ... باقي القواعد
            ], [
                // ... رسائل الخطأ
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // معالجة رفع الملفات
            $uploadFile = function($file, $folder) {
                if (!$file) return null;

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/teachers/' . $folder);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);
                return 'uploads/teachers/' . $folder . '/' . $fileName;
            };

            // تجهيز بيانات المدرس الجديد
            $data = [
                'teacher_name' => $request->teacher_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'age_group_id' => $request->age_group_id,
                'specializations' => $request->specializations,
                'experience_years' => $request->experience_years,
                'qualifications' => $request->qualifications,
                'certificates' => $request->certificates,
                'previous_experience' => $request->previous_experience,
                'availability' => $request->availability,
                'notes' => $request->notes,
            ];

            // رفع الملفات
            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $uploadFile($request->file('profile_image'), 'profiles');
            }
            if ($request->hasFile('cv_file')) {
                $data['cv_file'] = $uploadFile($request->file('cv_file'), 'cv');
            }
            if ($request->hasFile('certificates_file')) {
                $data['certificates_file'] = $uploadFile($request->file('certificates_file'), 'certificates');
            }
            if ($request->hasFile('id_photo')) {
                $data['id_photo'] = $uploadFile($request->file('id_photo'), 'id_photos');
            }
            if ($request->hasFile('certificate_good_conduct')) {
                $data['certificate_good_conduct'] = $uploadFile($request->file('certificate_good_conduct'), 'certificate_good_conduct');
            }

            // إنشاء المدرس الجديد
            $teacher = Teacher::create($data);

            DB::commit();

            Log::info('تم تسجيل مدرس جديد', [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->teacher_name,
                'email' => $teacher->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل المدرس بنجاح!',
                'data' => $teacher
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في تسجيل المدرس: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage()
            ], 500);
        }
    }



    public function showOtpForm(Request $request)
    {
        $email = $request->email;
        return view('teacher.auth.otp_verify', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = $request->input('otp_code');

        $user = Auth::guard('engineering')->user();

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
                'redirect_url' => route('engineering.dashboardController'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => trans('admin.Invalid or expired verification code.'),
        ], 422);
    }




    public function resendOtp()
    {
         $user = Auth::guard('engineering')->user();

        $user->otp_code = rand(100000, 999999);
        $user->otp_code_expires_at = now()->addMinutes(10);
        $user->save();

        $subject = __('رمز التفعيل الجديد');
        $view_file = 'emails.otp_verification';
        $body_data = [
            'otp_code' => $user->otp_code,
            'user' => $user,
        ];

        Mail::to($user->email)->send(new SendGenericMail($subject, $body_data, $view_file));

        return back()->with('success', __('تم إرسال رمز التفعيل مجددًا'));
    }
}
