<?php

namespace App\Http\Controllers\Platform\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Mail\SendGenericMail;
use App\Models\Appraiser;
use App\Models\Contractors;
use App\Models\EngineeringPartner;
use App\Models\Investors;
use App\Models\LegalPartner;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $data["provinces"] = Lookups::query()
            ->where("master_key", "province")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();

        return view('site.auth.register', compact('data'));
    }
    public function showRegisterDataForm()
    {
        $data["provinces"] = Lookups::query()
            ->where("master_key", "province")
            ->whereNot("parent_id", 0)
            ->where("status", 1)
            ->get();

        return view('site.auth.register_data', compact('data'));
    }
    public function register_data(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:contractor,eng,appraiser,legal',
        ]);

        $type = $request->user_type;

        try {
            // تحويل الحقول المشتركة
            $request->merge([
                'province_cd' => $request->input("{$type}_province_cd"),
                'city_cd' => $request->input("{$type}_city_cd"),
                'district_cd' => $request->input("{$type}_district_cd"),
            ]);

            DB::connection('sahmee')->beginTransaction();

            switch ($type) {
                case 'contractor':
                    Contractors::on('sahmee')->create([
                        'company_name'     => $request->contractor_name,
                        'mobile'           => $request->contractor_mobile,
                        'phone'            => $request->contractor_phone,
                        'email'            => $request->contractor_email,
                        'province_cd'      => $request->province_cd,
                        'city_cd'          => $request->city_cd,
                        'district_cd'      => $request->district_cd,
                        'address'          => $request->contractor_address,
                        'experience_years' => $request->contractor_experience,
                        'specializations'  => $request->contractor_specialties,
                        'password'         => Hash::make('default_password'),
                    ]);
                    break;

                case 'eng':
                    EngineeringPartner::on('sahmee')->create([
                        'company_name'     => $request->eng_name,
                        'mobile'           => $request->eng_mobile,
                        'email'            => $request->eng_email,
                        'province_cd'      => $request->province_cd,
                        'city_cd'          => $request->city_cd,
                        'district_cd'      => $request->district_cd,
                        'address'          => $request->eng_address,
                        'experience_years' => $request->eng_experience,
                        'specializations'  => $request->eng_specialties,
                        'website'          => $request->eng_website,
                        'password'         => Hash::make('default_password'),
                    ]);
                    break;

                case 'appraiser':
                    Appraiser::on('sahmee')->create([
                        'name'             => $request->appraiser_name,
                        'mobile_number'    => $request->appraiser_mobile,
                        'email'            => $request->appraiser_email,
                        'province_cd'      => $request->province_cd,
                        'city_cd'          => $request->city_cd,
                        'district_cd'      => $request->district_cd,
                        'address'          => $request->appraiser_address,
                        'experience_years' => $request->appraiser_experience,
                        'password'         => Hash::make('default_password'),
                    ]);
                    break;

                case 'legal':
                    LegalPartner::on('sahmee')->create([
                        'name'             => $request->legal_name,
                        'mobile_number'    => $request->legal_mobile,
                        'email'            => $request->legal_email,
                        'province_cd'      => $request->province_cd,
                        'city_cd'          => $request->city_cd,
                        'district_cd'      => $request->district_cd,
                        'address'          => $request->legal_address,
                        'experience_years' => $request->legal_experience,
                        'company_name'     => $request->legal_company,
                        'license_number'   => $request->legal_license,
                        'password'         => Hash::make('default_password'),
                    ]);
                    break;
            }

            DB::connection('sahmee')->commit();

            return response()->json([
                'status' => 'success',
                'message' => 'تم التسجيل بنجاح',
                'redirect' => url('/')
            ]);
        } catch (\Exception $e) {
            DB::connection('sahmee')->rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage()
            ], 500);
        }
    }



    public function register(Request $request)
    {
        $request->validate([

            'email' => 'required|email|unique:investors,email',
            'mobile' => 'required|unique:investors,mobile',
            'full_name' => 'required',

             'password' => 'required|string|min:8|confirmed',
        ]);

        $otpCode = rand(100000, 999999);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        $investor = Investors::create([

            'email' => $request->email,
            'full_name' => $request->full_name,
            'mobile' => $request->mobile,

            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
            'otp_code_expires_at' => $otpExpiresAt,
        ]);

        Auth::guard('investors')->login($investor);

        $subject = __('رمز التحقق من One Thousand');
        $view_file = 'emails.otp_verification';
        $body_data = [
            'otp_code' => $otpCode,
            'user' => $investor,
        ];

        Mail::to($investor->email)->send(new SendGenericMail($subject, $body_data, $view_file));

        return redirect()->route('investors.otp.form', ['email' => $investor->email])
            ->with('success', __('تم التسجيل بنجاح! الرجاء إدخال رمز التفعيل المرسل إلى بريدك الإلكتروني.'));
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->email;
        return view('site.auth.otp_verify', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = $request->input('otp_code');

        $user = Auth::guard('investors')->user();

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
                'redirect_url' => route('investors.dashboardController'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code.',
        ], 422);
    }




    public function resendOtp()
    {
         $user = Auth::guard('investors')->user();

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

    public function register_as_investor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:investors,email,' . ($request->investor_id ?? 'NULL') . ',id',
                'full_name' => 'required|string|max:255',
                'mobile' => ['required', 'regex:/^05[69]\d{7}$/'], // رقم الهاتف يبدأ بـ 05 ويحتوي على 10 أرقام
                'province_cd' => 'required|exists:lookups,id',
                'city_cd' => 'required|exists:lookups,id',
                'district_cd' => 'required|exists:lookups,id',
            ], [
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                'full_name.required' => 'الاسم الكامل مطلوب.',
                'full_name.string' => 'الاسم يجب أن يكون نصاً.',
                'full_name.max' => 'الاسم طويل جداً.',
                'mobile.required' => 'رقم الجوال مطلوب.',
                'mobile.regex' => 'صيغة رقم الجوال غير صحيحة.',
                'province_cd.required' => 'المحافظة مطلوبة.',
                'province_cd.exists' => 'المحافظة غير موجودة.',
                'city_cd.required' => 'المدينة مطلوبة.',
                'city_cd.exists' => 'المدينة غير موجودة.',
                'district_cd.required' => 'الحى مطلوبة.',
                'district_cd.exists' => 'الحى غير موجودة.',
                'password.required' => 'كلمة المرور مطلوبة.',
                'password.min' => 'كلمة المرور قصيرة جداً.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'حدثت أخطاء أثناء معالجة الطلب',
                ], 422);
            }
            $investors = new Investors();
            $investors->full_name = $request->full_name;
            $investors->mobile = $request->mobile;
            $investors->email = $request->email;
            $investors->password = Hash::make($request->password);
            $investors->province_cd = $request->province_cd;
            $investors->city_cd = $request->city_cd;
            $investors->district_cd = $request->district_cd;
            $investors->yearly_income = 0;
            $investors->save();

            Auth::guard('investors')->login($investors);

            // تجربة إرجاع البيانات
            return response()->json([
                'status' => true,
                'message' => __('تم التسجيل بنجاح!'),
                'redirect' => route('investors.dashboard.index', ['email' => $investors->email]),
            ]);

        } catch (\Exception $e) {
            \Log::error('خطأ أثناء التسجيل كمستثمر: '.$e->getMessage());
            return response()->json([
                'message' => 'خطأ داخلي في السيرفر: ' . $e->getMessage(),
            ], 500);
        }
    }

}
