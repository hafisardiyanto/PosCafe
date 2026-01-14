<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginLog;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cek login ke database
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        // 3. Regenerate session (security)
        $request->session()->regenerate();

        // 🔴 CATAT LOGIN KASIR (REAL-TIME)
    if (Auth::user()->role === 'kasir') {
        LoginLog::create([
            'user_id'    => Auth::id(),
            'role'       => Auth::user()->role,
            'login_at'   => Carbon::now(),
            'login_date' => Carbon::today(),
        ]);
    }

        // 4. Redirect ke dashboard
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
