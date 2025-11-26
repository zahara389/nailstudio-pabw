<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAdminController;  // ← TAMBAHKAN INI
use App\Http\Controllers\AnalyticsController;     // ← Tambahkan juga yang lain
use App\Http\Controllers\FaqController;           // ← Jika belum ada
use App\Http\Controllers\StockController;         // ← Jika belum ada
use App\Http\Controllers\ProductController;


// Route utama ke HomePage
Route::get('/', [HomePageController::class, 'index'])->name('home.index');

// Route untuk post booking
Route::post('/booking', [HomePageController::class, 'storeBooking'])->name('booking.store');

// Route katalog produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

//ADMIN PAGE
// 1. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');

// 2. Product Management
Route::resource('product', ProductAdminController::class)->names('product'); 

// 3. Analytics
Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

// 4. FAQ Message
Route::prefix('faq')->name('admin.faq.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('index');
});

// 5. Transaction History
Route::get('/transaction/history', [DashboardController::class, 'history'])->name('transaction.history');

// 6. Management Stock & Harga
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

// Route Logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
