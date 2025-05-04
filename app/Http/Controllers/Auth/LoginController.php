<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {
        // Cek apakah user sudah disetujui
        if (!$user->is_approved) {
            Auth::logout();

            // Kembalikan ke login dengan error
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum disetujui oleh admin.',
            ]);
        }

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
