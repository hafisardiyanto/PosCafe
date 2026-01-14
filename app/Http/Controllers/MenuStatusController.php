<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuStatusController extends Controller
{
    public function open(Menu $menu)
    {
        // INTERNAL
        if ($menu->source === 'internal') {
            $menu->update(['availability' => 'open']);
        }

        // UMKM
        if ($menu->source === 'umkm' && $menu->stock > 0) {
            $menu->update(['availability' => 'open']);
        }

        return back()->with('success','Menu dibuka');
    }

    public function close(Menu $menu)
    {
        $menu->update(['availability' => 'closed']);
        return back()->with('success','Menu ditutup');
    }
}
