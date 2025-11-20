<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; 
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'namaproduct', 'category', 'stock', 'price', 'status', 'image', 'discount', 'added'
    ];

    // Relasi
    public function reviews() { return $this->hasMany(Review::class, 'product_id', 'id_product'); }
    public function favorites() { return $this->hasMany(Favorite::class, 'product_id', 'id_product'); }
}