<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuStock extends Model
{
    protected $fillable = ['menu_id','qty','user_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
