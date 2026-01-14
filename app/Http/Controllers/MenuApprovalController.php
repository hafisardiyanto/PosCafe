<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuApprovalController extends Controller
{
    /* =================================================
       KASIR AJUKAN MENU UMKM / TAMBAH QTY
       ================================================= */
    public function storeByKasir(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'nullable|numeric',
            'qty'   => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        // upload gambar (opsional)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('menu-images', 'public');
        }

        // cek menu sudah ada & approved
        $menu = Menu::where('name', $request->name)
            ->where('status', 'approved')
            ->first();

        /* ===============================
           JIKA MENU SUDAH ADA
           =============================== */
        if ($menu) {
            // kasir hanya boleh tambah qty
            $menu->increment('stock', $request->qty);

            // catat histori stok
            MenuStock::create([
                'menu_id' => $menu->id,
                'qty'     => $request->qty,
                'user_id' => Auth::id(),
            ]);

            return back()->with('success', 'Qty menu berhasil ditambahkan');
        }

        /* ===============================
           JIKA MENU BELUM ADA (AJUKAN)
           =============================== */
        Menu::create([
            'name'       => $request->name,
            'price'      => $request->price,
            'stock'      => $request->qty,
            'status'     => 'pending',      // WAJIB approval
            'source'     => 'umkm',
            'image'      => $imagePath,
            'created_by' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Menu UMKM berhasil diajukan, menunggu persetujuan Admin / Manager'
        );
    }

    /* =================================================
       ADMIN / MANAGER TAMBAH MENU (LANGSUNG APPROVED)
       ================================================= */
    public function storeByAdmin(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|unique:menus,name',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'source'=> 'required|in:internal,umkm',
        ]);

        Menu::create([
            'name'       => $request->name,
            'price'      => $request->price,
            'stock'      => $request->source === 'umkm' ? $request->stock : null,
            'status'     => 'approved',     // TANPA approval
            'source'     => $request->source,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    /* =================================================
       APPROVAL MENU UMKM
       ================================================= */
    public function approve($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['status' => 'approved']);

        return back()->with('success', 'Menu berhasil disetujui');
    }

    public function reject($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['status' => 'rejected']);

        return back()->with('success', 'Menu ditolak');
    }

    /* =================================================
       HALAMAN MENU
       ================================================= */
    public function index()
    {
        $approvedMenus = Menu::where('status', 'approved')->get();
        $pendingMenus  = Menu::where('status', 'pending')->get();

        return view('menus.index', compact(
            'approvedMenus',
            'pendingMenus'
        ));
    }
}
