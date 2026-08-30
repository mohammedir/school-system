<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureContractorsEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('contractors')->check()) {
            return redirect()->route('contractors.login');
        }

        $user = Auth::guard('contractors')->user();

        if (! $user || ! $user->hasVerifiedEmail()) {
            return redirect()->route('contractors.otp.form', ['email' => $user->email]);
        }

        return $next($request);
    }
}
