<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginLog::with('user');

        // FILTER TANGGAL MULAI
        if ($request->filled('from_date')) {
            $query->whereDate('login_at', '>=', $request->from_date);
        }

        // FILTER TANGGAL AKHIR
        if ($request->filled('to_date')) {
            $query->whereDate('login_at', '<=', $request->to_date);
        }

        // FILTER JAM (OPTIONAL)
        if ($request->filled('from_time')) {
            $query->whereTime('login_at', '>=', $request->from_time);
        }

        if ($request->filled('to_time')) {
            $query->whereTime('login_at', '<=', $request->to_time);
        }

        $logs = $query->orderBy('login_at', 'desc')->get();

        return view('logs.index', compact('logs'));
    }
}
