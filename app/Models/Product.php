<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'stock',
        'price',
        'discount',
        'status',
        'image',
        'rating',
        'review_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'stock' => 'integer',
        'rating' => 'decimal:1',
        'review_count' => 'integer',
    ];

    protected $appends = [
        'discounted_price',
        'final_price',
    ];

    public function getDiscountedPriceAttribute(): float
    {
        $price = (float) $this->price;
        $discount = max(0.0, (float) $this->discount);

        if ($discount <= 0) {
            return $price;
        }

        return round($price - (($discount / 100) * $price), 2);
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->discounted_price;
    }

    public function getNamaproductAttribute(): string
    {
        return $this->attributes['name'] ?? '';
    }

    public function setNamaproductAttribute($value): void
    {
        $this->attributes['name'] = $value;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
     * Query Scopes
     */

    public function scopeSearch($query, string $term)
    {
        $like = '%' . strtolower($term) . '%';

        return $query->whereRaw('LOWER(name) LIKE ?', [$like]);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}

