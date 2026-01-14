<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role user
        $userRole = Auth::user()->role;

        // Cek apakah role user diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
