<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json(['message'=>'Login gagal'],401);
        }

        $token = $request->user()->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $request->user(),
            'token' => $token
        ]);
    }
}
