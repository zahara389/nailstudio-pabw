<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;

// Route utama ke HomePage
Route::get('/', [HomePageController::class, 'index'])->name('home.index');

// Route untuk post booking
Route::post('/booking', [HomePageController::class, 'storeBooking'])->name('booking.store');