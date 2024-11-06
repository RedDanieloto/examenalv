<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();
            return redirect('/login')->withErrors(['Your account is not activated. Please check your email.']);
        }

        return $next($request);
    }
}
