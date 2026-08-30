<?php

namespace App\Http\Controllers\Teachers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('teacher.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'password' => 'required|string|min:8',
        ]);
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('teachers')->attempt($credentials)) {
            $request->session()->regenerate();


                return response()->json([
                    'status' => 'success',
                    'redirect' => route('teachers.dashboard'),
                    'message' => 'تم تسجيل الدخول بنجاح'
                ]);


         }

         $errorMessage = 'بيانات الدخول غير صحيحة أو لم يتم تفعيل الحساب.';


            return response()->json([
                'status' => 'error',
                'message' => $errorMessage
            ], 422);


    }
    public function logout(Request $request)
    {
        Auth::guard('teachers')->logout();
        return redirect('/teachers/login');
    }
}
