<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'kasir_id',
        'start_time',
        'end_time',
        'opening_cash',
        'closing_cash',
    ];

    /* ================= RELATION ================= */

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }
}
