<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersQuestion extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit agar tidak salah baca
    protected $table = 'user_questions';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'question',
        'status', // Pastikan kolom 'status' ada di tabel Anda
    ];

    // Relasi ke User (Opsional, berguna jika Admin ingin melihat siapa yang bertanya)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}