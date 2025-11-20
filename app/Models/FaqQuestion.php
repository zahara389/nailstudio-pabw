<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq'; // Nama tabel singular

    protected $fillable = ['question', 'answer', 'admin_id'];
}