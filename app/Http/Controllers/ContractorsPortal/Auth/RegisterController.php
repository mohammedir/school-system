<?php

namespace App\Http\Controllers\ContractorsPortal\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendGenericMail;
use App\Models\Contractors;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        return view('contractors.auth.register', compact('data'));
    }

    public function register(Request $request)
    {

        $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'province_cd' => 'required',
            'city_cd' => 'required',
            'district_cd' => 'required',
            'address' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'specializations' => 'required|string|max:255',
            'email' => 'required|email|unique:contractors,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $otpCode = rand(100000, 999999);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        $partner = Contractors::create([
            'company_name' => $request->company_name,
            'mobile' => $request->mobile,
            'province_cd' => $request->province_cd,
            'city_cd' => $request->city_cd,
            'district_cd' => $request->district_cd,
            'address' => $request->address,
            'experience_years' => $request->experience_years,
            'specializations' => $request->specializations,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otpCode,
            'otp_code_expires_at' => $otpExpiresAt,
        ]);

        Auth::guard('contractors')->login($partner);

        $subject = __('رمز التحقق من One Thousand');
        $view_file = 'emails.otp_verification';
        $body_data = [
            'otp_code' => $otpCode,
            'user' => $partner,
        ];

        Mail::to($request->email)->send(new SendGenericMail($subject, $body_data, $view_file));

        return redirect()->route('contractors.otp.form', ['email' => $partner->email])
            ->with('success', __('تم التسجيل بنجاح! الرجاء إدخال رمز التفعيل المرسل إلى بريدك الإلكتروني.'));
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->email;
        return view('contractors.auth.otp_verify', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = $request->input('otp_code');

        $user = Auth::guard('contractors')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => trans('admin.User not authenticated.'),
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
                'redirect_url' => route('contractors.dashboardController'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => trans('admin.Invalid or expired verification code.'),
        ], 422);
    }




    public function resendOtp()
    {
        $user = Auth::guard('contractors')->user();

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
