<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Kirim email reset password
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // CEK EMAIL TERDAFTAR ATAU TIDAK
        if (!User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Email anda belum terdaftar / salah',
            ]);
        }

        // KIRIM LINK RESET PASSWORD
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password telah dikirim ke email anda.')
            : back()->withErrors(['email' => __($status)]);
    }
}
