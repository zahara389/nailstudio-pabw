<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAdminController;  // ← TAMBAHKAN INI
use App\Http\Controllers\AnalyticsController;     // ← Tambahkan juga yang lain
use App\Http\Controllers\FaqController;           // ← Jika belum ada
use App\Http\Controllers\StockController;         // ← Jika belum ada


//ADMIN PAGE

// 1. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');

// 2. Product Management
Route::get('product', [ProductAdminController::class, 'index'])->name('product.index');
Route::get('product/create', [ProductAdminController::class, 'create'])->name('product.create');
Route::post('product', [ProductAdminController::class, 'store'])->name('product.store');
Route::get('product/{id}/edit', [ProductAdminController::class, 'edit'])->name('product.edit');
Route::put('product/{id}', [ProductAdminController::class, 'update'])->name('product.update');
Route::delete('product/{id}', [ProductAdminController::class, 'destroy'])->name('product.destroy');

// 3. Analytics
Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
Route::get('analytics/realtime', [AnalyticsController::class, 'getRealtimeData'])->name('analytics.realtime');
Route::get('analytics/export', [AnalyticsController::class, 'exportSalesReport'])->name('analytics.export');

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