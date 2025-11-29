<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    // Karena nama model 'Orders' (jamak), Laravel akan otomatis mencari tabel 'orders'.
    // Jadi kita tidak wajib mendefinisikan $table, tapi bisa ditambahkan untuk memastikan.
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'order_status',          // SESUAIKAN: Di DB namanya 'order_status', bukan 'status'
        'payment_method',
        'proof_of_payment_path', // TAMBAHAN: Sesuai kolom di DB
        'discount_amount',       // TAMBAHAN: Sesuai kolom di DB
        // 'shipping_address',   // DI-COMMENT: Tidak ada di screenshot DB
        // 'notes',              // DI-COMMENT: Tidak ada di screenshot DB
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        // Pastikan Anda juga punya model 'OrderItem' (atau 'OrderItems' jika Anda menggunakan jamak)
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        // SESUAIKAN: Kolom 'order_status' dan value enum 'Complete' (tanpa d)
        return $query->where('order_status', 'Complete');
    }

    public function scopePending($query)
    {
        return $query->where('order_status', 'Pending');
    }
}