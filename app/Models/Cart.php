<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart'; // Nama tabel singular

    protected $fillable = ['user_id', 'status', 'order_status'];

    // Relasi
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(CartItem::class, 'cart_id'); }
    public function buktiBayar() { return $this->hasOne(BuktiBayar::class, 'cart_id'); }
}