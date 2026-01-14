<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShiftController extends Controller
{
     public function start(Request $request)
    {
        Shift::create([
            'kasir_id' => auth()->id(),
            'start_time' => now(),
            'opening_cash' => $request->opening_cash
        ]);
    }

    public function end(Request $request, $id)
    {
        Shift::findOrFail($id)->update([
            'end_time' => now(),
            'closing_cash' => $request->closing_cash
        ]);
    }
}
