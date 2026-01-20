<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * HALAMAN INPUT TRANSAKSI KASIR
     */
    public function index()
    {
        $menus = Menu::where('status', 'approved')
            ->orderBy('source')   // internal & umkm terpisah
            ->orderBy('name')
            ->get();

        return view('kasir.transaksi', compact('menus'));
    }

    /**
     * SIMPAN TRANSAKSI
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'items.*.menu_id' => 'required|exists:menus,id',
                'items.*.qty'     => 'required|integer|min:0',
            ]);

            $transaction = Transaction::create([
                'kasir_id'    => auth()->id(),
                'total_price' => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {

                if ($item['qty'] <= 0) {
                    continue;
                }

                $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

                // ❌ MENU CLOSED TIDAK BOLEH DIBELI
                if ($menu->availability === 'closed') {
                    throw new \Exception(
                        'Menu '.$menu->name.' sedang HABIS'
                    );
                }

                // ❌ STOK UMKM HABIS
                if ($menu->source === 'umkm' && $menu->stock < $item['qty']) {
                    throw new \Exception(
                        'Stok '.$menu->name.' tidak mencukupi'
                    );
                }

                $subtotal = $menu->price * $item['qty'];

                $transaction->items()->create([
                    'menu_id'  => $menu->id,
                    'qty'      => $item['qty'],
                    'price'    => $menu->price,
                    'subtotal' => $subtotal
                ]);

                // Kurangi stok UMKM
                if ($menu->source === 'umkm') {
                    $menu->stock -= $item['qty'];

                    if ($menu->stock <= 0) {
                        $menu->availability = 'closed';
                    }

                    $menu->save();
                }

                $total += $subtotal;
            }

            if ($total <= 0) {
                throw new \Exception('Tidak ada menu yang dipilih');
            }

            $transaction->update(['total_price' => $total]);

            DB::commit();

            return redirect()
                ->route('kasir.transaksi')
                ->with('success', 'Transaksi berhasil. Total: Rp '.number_format($total));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }
}
