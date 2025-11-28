<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

<<<<<<< HEAD
    // Nama table di database
    protected $table = 'products';
=======
    // Menghapus protected $table = 'product' agar Laravel mencari 'products' (Bentuk jamak)
    protected $primaryKey = 'id_product'; 
    public $incrementing = true;
    protected $keyType = 'int';
>>>>>>> b29b99e (feat: Add landing page components including booking, categories, hero, team, and top products sections)

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

<<<<<<< HEAD
    // Casting tipe data
    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'integer',
        'stock' => 'integer',
    ];

    // Accessor untuk harga setelah diskon
    public function getPriceAfterDiscountAttribute()
=======
    // Relasi ke Category (Asumsi Anda punya Category Model)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id_category'); 
        // NOTE: 'category' di sini adalah nama foreign key di tabel products
    }

    // Accessor untuk harga setelah diskon
    public function getDiscountedPriceAttribute()
>>>>>>> b29b99e (feat: Add landing page components including booking, categories, hero, team, and top products sections)
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }
<<<<<<< HEAD

    // Relasi
    public function reviews() { 
        return $this->hasMany(Review::class, 'product_id', 'id_product'); 
    }
    
    public function favorites() { 
        return $this->hasMany(Favorite::class, 'product_id', 'id_product'); 
    }
}

=======
}
>>>>>>> b29b99e (feat: Add landing page components including booking, categories, hero, team, and top products sections)
