<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403);
        }

        // [GPT] Tambahan: jika akun disuspend, tolak akses dashboard toko
        if ($user->is_suspended && $request->is('customer/*')) {
            return redirect('/')->with('error', 'Akun toko Anda sedang disuspend. Silakan hubungi admin.');
        }

        return $next($request);
    }
}
