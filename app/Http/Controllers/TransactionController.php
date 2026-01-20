<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        // Buat transaksi
        $transaction = Transaction::create([
            'kasir_id' => auth()->id(),
            'total_price' => 0
        ]);

        $total = 0;

        foreach ($request->items as $item) {

            if ($item['qty'] <= 0) {
                continue;
            }

            $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);

            // CEK MENU CLOSED
            if ($menu->availability === 'closed') {
                DB::rollBack();
                return back()->withErrors('Menu '.$menu->name.' sedang habis / closed');
            }

            // CEK STOK UMKM
            if ($menu->source === 'umkm' && $menu->stock < $item['qty']) {
                DB::rollBack();
                return back()->withErrors('Stok menu '.$menu->name.' tidak mencukupi');
            }

            $subtotal = $menu->price * $item['qty'];

            // Simpan item transaksi
            $transaction->items()->create([
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'price' => $menu->price,
                'subtotal' => $subtotal
            ]);

            // Kurangi stok UMKM
            if ($menu->source === 'umkm') {
                $menu->decrement('stock', $item['qty']);

                // AUTO CLOSED jika stok habis
                if ($menu->stock - $item['qty'] <= 0) {
                    $menu->update(['availability' => 'closed']);
                }
            }

            $total += $subtotal;
        }

        // Update total transaksi
        $transaction->update([
            'total_price' => $total
        ]);

        DB::commit();

        return redirect()->route('kasir.transaksi')
            ->with('success', 'Transaksi berhasil. Total: Rp '.number_format($total));
    }
}
