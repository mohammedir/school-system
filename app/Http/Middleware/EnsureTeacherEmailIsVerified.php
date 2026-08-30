<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacherEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('teachers')->check()) {
            return redirect()->route('teachers.login');
        }

        $user = Auth::guard('teachers')->user();

        /*if (! $user || ! $user->hasVerifiedEmail()) {
            return redirect()->route('teachers.otp.form', ['email' => $user->email]);
        }*/

        return $next($request);
    }
}
