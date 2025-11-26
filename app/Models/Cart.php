<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $table = 'carts'; 

    // Pastikan field yang boleh diisi juga sudah ada (sesuaikan dengan migrasi kamu)
    protected $guarded = ['id'];
    
    // Relasi ke User (sesuai kode controller kamu)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Items (sesuai kode controller kamu)
    public function items()
    {
        // Sesuaikan 'cart_items' dengan nama tabel item kamu
        return $this->hasMany(CartItem::class); 
    }
}