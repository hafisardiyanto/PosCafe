<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id
        qty',
        'price',
        'subtotal'
    ];

    /* ================= RELATION ================= */

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
