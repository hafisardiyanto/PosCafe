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

        // buat transaksi
        $transaction = Transaction::create([
            'kasir_id' => auth()->id(),
            'total_price' => 0
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);

            // cek stok UMKM
            if ($menu->source === 'umkm' && $menu->stock < $item['qty']) {
                return back()->withErrors('Stok menu '.$menu->name.' tidak mencukupi');
            }

            $subtotal = $menu->price * $item['qty'];

            $transaction->items()->create([
                'menu_id' => $menu->id,
                'qty' => $item['qty'],
                'price' => $menu->price,
                'subtotal' => $subtotal
            ]);

            // kurangi stok UMKM
            if ($menu->source === 'umkm') {
                $menu->decrement('stock', $item['qty']);
            }

            $total += $subtotal;
        }

        $transaction->update([
            'total_price' => $total
        ]);

        DB::commit();

        // setelah decrement stock UMKM
if ($menu->source === 'umkm') {
    $menu->decrement('stock', $item['qty']);

    // AUTO CLOSED jika stok habis
    if ($menu->stock <= 0) {
        $menu->update(['availability' => 'closed']);
    }
}


        return redirect()->route('kasir.transaksi')
            ->with('success', 'Transaksi berhasil. Total: Rp '.number_format($total));
    }
}
