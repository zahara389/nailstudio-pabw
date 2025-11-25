<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; 
    protected $primaryKey = 'id_product'; // ← Primary key custom
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'namaproduct', 'category', 'stock', 'price', 'status', 'image', 'discount', 'added'
    ];

    // ← TAMBAHKAN: Default values
    protected $attributes = [
        'status' => 'draft',
        'discount' => 0,
        'stock' => 0,
    ];

    // ← TAMBAHKAN: Accessor untuk harga setelah diskon
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }

    // Relasi
    public function reviews() { 
        return $this->hasMany(Review::class, 'product_id', 'id_product'); 
    }
    
    public function favorites() { 
        return $this->hasMany(Favorite::class, 'product_id', 'id_product'); 
    }
}