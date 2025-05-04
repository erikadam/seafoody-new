<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // ✅ Gunakan namespace yang benar

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Setelah login, ke mana user akan diarahkan?
     * Ini hanya fallback, akan diabaikan jika method `authenticated()` di bawah ada.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Override method ini untuk redirect berdasarkan role.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    /**
     * Konstruktor: hanya user tamu yang bisa akses login.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
