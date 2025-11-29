<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts'; 
    protected $guarded = ['id'];
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Items
    public function items()
    {
        return $this->hasMany(CartItem::class); 
    }

    // ✅ TAMBAHKAN INI - Accessor untuk menghitung total harga
    public function getTotalPriceAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->quantity * $item->unit_price;
        });
    }
}