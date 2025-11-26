<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // PERBAIKAN 1: Sesuaikan nama tabel dengan database (plural)
    protected $table = 'cart_items'; 

    // PERBAIKAN 2: Sesuaikan nama kolom dengan database
    // qty -> quantity
    // price -> unit_price
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    // Relasi ke Cart
    public function cart() 
    { 
        return $this->belongsTo(Cart::class, 'cart_id'); 
    }
    
    // Relasi ke Product
    public function product() 
    { 
        // Pastikan parameter ke-3 adalah 'id' (default primary key tabel products)
        // Kecuali jika di tabel products kamu memang mengubah nama ID-nya jadi 'id_product'
        return $this->belongsTo(Product::class, 'product_id'); 
    }
}