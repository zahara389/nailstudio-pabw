<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs'; // Sesuaikan dengan nama tabel di migration

    protected $fillable = [
        'question',
        'answer',
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
