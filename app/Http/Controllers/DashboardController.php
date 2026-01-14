<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // SELALU DIHITUNG
        $totalKasir = User::where('role', 'kasir')->count();

         if ($role === 'admin') {
            return view('dashboard.admin', compact('totalKasir'));
        }

        if ($role === 'manager') {
            return view('dashboard.manager');
        }

        if ($role === 'kasir') {
            return view('dashboard.kasir');
        }

        abort(403);
    }
}
