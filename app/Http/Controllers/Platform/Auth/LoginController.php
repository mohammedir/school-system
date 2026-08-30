<?php

namespace App\Http\Controllers\Platform\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('site.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('investors')->attempt($credentials)) {
            $request->session()->regenerate();


                return response()->json([
                    'status' => 'success',
                    'redirect' => route('investors.dashboard.index'),
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
        Auth::guard('investors')->logout();
        return redirect('/');
    }

    public function login_as_investor(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('investors')->attempt($credentials)) {
            $request->session()->regenerate();


            return response()->json([
                'status' => true,
                'redirect' => route('investors.dashboard.index'),
                'message' => 'تم تسجيل الدخول بنجاح'
            ]);



        }

        $errorMessage = 'بيانات الدخول غير صحيحة';


        return response()->json([
            'status' => 'error',
            'message' => $errorMessage
        ], 422);


    }

}
