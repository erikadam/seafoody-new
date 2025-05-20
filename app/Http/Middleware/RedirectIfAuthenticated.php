<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif (Auth::user()->role === 'customer') {
        return redirect('/customer/dashboard');
    }
    return redirect('/');
            }
        }

        return $next($request);
    }
}
