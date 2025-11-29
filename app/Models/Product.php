<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Nama table di database
    protected $table = 'products';

    // Primary key (default: id)
    protected $primaryKey = 'id';

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'name',
        'slug',
        'category',
        'stock',
        'price',
        'discount',
        'status',
        'image',
    ];
    
    // Asumsi: Kita ganti 'is_top_product' menjadi 'status' di controller
    // Jadi, kita tidak memerlukan kolom is_top_product di Model ini

    // Casting tipe data
    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'integer',
        'stock' => 'integer',
    ];

    // Accessor untuk harga setelah diskon
    public function getPriceAfterDiscountAttribute()
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

