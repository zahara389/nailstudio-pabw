<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'nama_produk',
        'harga',
        'qty',
    ];

    /**
     * Get the transaction that owns the detail.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'qty' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}