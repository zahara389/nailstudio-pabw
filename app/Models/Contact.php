<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Ini penting supaya Laravel boleh masukin data ke kolom name & message
    protected $fillable = ['name', 'message'];
}