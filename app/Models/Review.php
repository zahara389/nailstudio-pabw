<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews'; // Nama tabel plural

    protected $fillable = [
        'user_id', 'product_id', 'rating', 'packaging', 'pigmentation', 
        'longwear', 'texture', 'value_for_money', 'recommend', 
        'repurchase', 'usage_period', 'tag', 'comment', 'photo'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class, 'product_id', 'id_product'); }
}