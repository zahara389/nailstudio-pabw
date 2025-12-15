<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    
    use HasFactory;

    protected $table = 'cart_items'; 

    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

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
