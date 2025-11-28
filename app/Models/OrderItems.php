<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    
    // Karena nama tabel pakai underscore tapi model CamelCase jamak, 
    // kadang Laravel bingung. Aman-nya didefinisikan.
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',      // Update nama kolom
        'discount_amount', // Update nama kolom
        'subtotal_item',   // Update nama kolom
    ];

    // Relasi ke Order utama
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}