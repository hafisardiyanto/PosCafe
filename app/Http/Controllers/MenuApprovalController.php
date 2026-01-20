<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuApprovalController extends Controller
{
    /* =================================================
       KASIR AJUKAN MENU UMKM / TAMBAH STOK
       ================================================= */
    public function storeByKasir(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'nullable|numeric',
            'qty'   => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        /* ===== UPLOAD GAMBAR (OPSIONAL) ===== */
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('menu-images', 'public');
        }

        /* ===== CEK MENU UMKM SUDAH APPROVED ===== */
        $menu = Menu::where('name', $request->name)
            ->where('source', 'umkm')
            ->where('status', 'approved')
            ->first();

        /* =========================================
           JIKA MENU SUDAH ADA & APPROVED
           ========================================= */
        if ($menu) {
            $menu->increment('stock', $request->qty);

            MenuStock::create([
                'menu_id' => $menu->id,
                'qty'     => $request->qty,
                'user_id' => Auth::id(),
                'note'    => 'Tambah stok oleh kasir',
            ]);

            // buka menu jika sebelumnya closed
            if ($menu->availability === 'closed') {
                $menu->update(['availability' => 'open']);
            }

            return back()->with('success', 'Stok menu berhasil ditambahkan');
        }

        /* =========================================
           MENU BARU → STATUS PENDING (PERLU APPROVAL)
           ========================================= */
        Menu::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->qty,
            'status'       => 'pending',
            'source'       => 'umkm',
            'availability' => 'closed',
            'images'       => $imagePath ? json_encode([$imagePath]) : null,
            'created_by'   => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Menu UMKM berhasil diajukan dan menunggu approval Admin / Manager'
        );
    }

    /* =================================================
       ADMIN / MANAGER TAMBAH MENU (LANGSUNG APPROVED)
       ================================================= */
    public function storeByAdmin(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|unique:menus,name',
            'price'  => 'required|numeric|min:0',
            'stock'  => 'nullable|integer|min:0',
            'source' => 'required|in:internal,umkm',
        ]);

        Menu::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'stock'        => $request->source === 'umkm' ? $request->stock : null,
            'status'       => 'approved',
            'source'       => $request->source,
            'availability' => 'open',
            'created_by'   => Auth::id(),
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    /* =================================================
       APPROVAL MENU UMKM
       ================================================= */
    public function approve($id)
    {
        $menu = Menu::where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $menu->update([
            'status'       => 'approved',
            'availability' => 'open',
        ]);

        return back()->with('success', 'Menu UMKM berhasil disetujui');
    }

    public function reject($id)
    {
        $menu = Menu::where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $menu->update(['status' => 'rejected']);

        return back()->with('success', 'Menu UMKM ditolak');
    }

    /* =================================================
       HALAMAN MENU (ADMIN / MANAGER)
       ================================================= */
    public function index()
    {
         // SEMUA MENU APPROVED
    $approvedMenus = Menu::where('status', 'approved')
        ->orderBy('source')
        ->orderBy('name')
        ->get();

    // KHUSUS MENU UMKM YANG SUDAH APPROVED (UNTUK DROPDOWN)
    $approvedUmkmMenus = Menu::where('status', 'approved')
        ->where('source', 'umkm')
        ->orderBy('name')
        ->get();

    // MENU UMKM MENUNGGU APPROVAL
    $pendingMenus = Menu::where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('menus.index', compact(
        'approvedMenus',
        'approvedUmkmMenus',
        'pendingMenus'
    ));
    }

    /* =================================================
       OPEN / CLOSE MENU (KASIR & ADMIN)
       ================================================= */
    public function close($id)
    {
        Menu::where('id', $id)->update([
            'availability' => 'closed'
        ]);

        return back()->with('success', 'Menu berhasil ditutup');
    }

    public function open($id)
    {
        Menu::where('id', $id)->update([
            'availability' => 'open'
        ]);

        return back()->with('success', 'Menu berhasil dibuka');
    }
}
