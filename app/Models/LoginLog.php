<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'login_at',
        'login_date',
    ];

    protected $casts = [
        'login_at'   => 'datetime',
        'login_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
