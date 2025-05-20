<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Redirect users after login based on their role.
     */
    protected function authenticated(Request $request, $user)
    {
        // [GPT] Hanya admin redirect ke dashboard admin
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        // Semua user dan customer ke home
        return redirect('/');
    }
}
