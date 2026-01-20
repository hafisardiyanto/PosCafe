<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Simpan transaksi kasir
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // ================= VALIDASI =================
            $request->validate([
                'items.*.menu_id' => 'required|exists:menus,id',
                'items.*.qty'     => 'required|integer|min:0',
            ]);

            // ================= BUAT TRANSAKSI =================
            $transaction = Transaction::create([
                'kasir_id'    => auth()->id(),
                'total_price' => 0
            ]);

            $total = 0;

            // ================= LOOP ITEM =================
            foreach ($request->items as $item) {

                // skip jika qty 0
                if ($item['qty'] <= 0) {
                    continue;
                }

                // LOCK ROW MENU (ANTI DOUBLE TRANSAKSI)
                $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

                // ================= CEK STATUS MENU =================
                if ($menu->availability === 'closed') {
                    throw new \Exception('Menu '.$menu->name.' sedang habis / closed');
                }

                // ================= CEK STOK UMKM =================
                if ($menu->source === 'umkm' && $menu->stock < $item['qty']) {
                    throw new \Exception('Stok menu '.$menu->name.' tidak mencukupi');
                }

                // ================= HITUNG SUBTOTAL =================
                $subtotal = $menu->price * $item['qty'];

                // ================= SIMPAN ITEM TRANSAKSI =================
                $transaction->items()->create([
                    'menu_id'  => $menu->id,
                    'qty'      => $item['qty'],
                    'price'    => $menu->price,
                    'subtotal' => $subtotal
                ]);

                // ================= KURANGI STOK UMKM =================
                if ($menu->source === 'umkm') {
                    $menu->stock -= $item['qty'];

                    // AUTO CLOSED JIKA STOK HABIS
                    if ($menu->stock <= 0) {
                        $menu->availability = 'closed';
                    }

                    $menu->save();
                }

                $total += $subtotal;
            }

            // ================= UPDATE TOTAL =================
            if ($total <= 0) {
                throw new \Exception('Tidak ada item yang dipilih');
            }

            $transaction->update([
                'total_price' => $total
            ]);

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
