<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $table = 'newsletter_subscribers'; // Nama tabel plural
    public $timestamps = false; // Hanya custom subscribed_at

    protected $fillable = ['email', 'subscribed_at', 'user_id'];
}