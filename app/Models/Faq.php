<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    // Tambahkan kolom-kolom baru di sini
    protected $fillable = [
        'user_id',
        'question',
        'answer',
        'status'
    ];

    // Tambahkan relasi ke User agar controller tidak error saat memanggil with('user')
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}