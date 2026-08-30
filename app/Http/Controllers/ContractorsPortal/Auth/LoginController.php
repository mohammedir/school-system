<?php

namespace App\Http\Controllers\ContractorsPortal\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('contractors.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('contractors')->attempt($credentials)) {
            $request->session()->regenerate();


            return response()->json([
                'status' => 'success',
                'redirect' => route('contractors.dashboardController'),
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
        Auth::guard('contractors')->logout();
        return redirect('/contractors/login');
    }
}
