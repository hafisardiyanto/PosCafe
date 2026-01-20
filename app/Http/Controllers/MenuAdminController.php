<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuAdminController extends Controller
{
    /**
     * FORM INPUT MENU ADMIN
     */
    public function create()
    {
        // MENU UMKM YANG SUDAH DI-APPROVED OLEH ADMIN
        $approvedUmkmMenus = Menu::where('source', 'umkm')
            ->where('status', 'approved')
            ->get();

        // SEMUA MENU (INTERNAL + UMKM)
        $allMenus = Menu::orderBy('source')
            ->orderBy('name')
            ->get();

        return view('admin.menu.create', compact('approvedUmkmMenus', 'allMenus'));
    }

    /**
     * SIMPAN MENU ADMIN
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'nullable|exists:menus,id',
            'name'    => 'required|string',
            'price'   => 'required|numeric|min:0',
            'source'  => 'required|in:internal,umkm',
            'stock'   => 'nullable|integer|min:0'
        ]);

        Menu::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'source'       => $request->source,
            'stock'        => $request->source === 'umkm' ? $request->stock : null,
            'availability' => 'open',
            'status'       => 'approved'
        ]);

        return redirect()
            ->back()
            ->with('success', 'Menu berhasil disimpan');
    }
}
