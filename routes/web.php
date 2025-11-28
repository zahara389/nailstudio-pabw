<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAdminController;  
use App\Http\Controllers\AnalyticsController;     
use App\Http\Controllers\StockController;         
use App\Http\Controllers\FaqMessageController;   
use App\Http\Controllers\TransactionController;   
use App\Http\Controllers\StockManagementController; 


//ADMIN PAGE

// /1. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');


// 2. Product Management
Route::get('/product', [ProductAdminController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductAdminController::class, 'create'])->name('product.create');
Route::post('/product', [ProductAdminController::class, 'store'])->name('product.store');
Route::get('/product/{id}/edit', [ProductAdminController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductAdminController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductAdminController::class, 'destroy'])->name('product.destroy');

// 3. Analytics
Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
Route::get('/analytics/realtime', [AnalyticsController::class, 'getRealtimeData'])->name('analytics.realtime');
Route::get('/analytics/export', [AnalyticsController::class, 'exportSalesReport'])->name('analytics.export');

// 4. FAQ
Route::get('/admin/faq', [FaqMessageController::class, 'index'])->name('admin.faq.index');
Route::post('/admin/faq/submit', [FaqMessageController::class, 'submitAnswer'])->name('admin.faq.submit');
// CREATE pertanyaan (opsional, jika admin atau member mau tambah)
Route::post('/admin/faq/store', [FaqMessageController::class, 'store'])->name('admin.faq.store');
Route::get('/admin/faq/{id}', [FaqMessageController::class, 'show'])->name('admin.faq.show');
Route::put('/admin/faq/{id}', [FaqMessageController::class, 'update'])->name('admin.faq.update');
Route::delete('/admin/faq/{id}', [FaqMessageController::class, 'destroy'])->name('admin.faq.destroy');

// 5. Transaction History
Route::get('/transaction/history', [TransactionController::class, 'index'])->name('transaction.history');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

// 6. Management Stock & Harga
Route::get('/stock-management', [StockManagementController::class, 'index'])->name('stock.index');  
Route::post('/stock/add', [StockManagementController::class, 'updateStock'])->name('stock.updateStock');
Route::post('/stock/price', [StockManagementController::class, 'updatePrice'])->name('stock.updatePrice');
Route::get('/stock-management/create', [StockManagementController::class, 'create'])->name('stock.create');
Route::post('/stock-management/store', [StockManagementController::class, 'store'])->name('stock.store');
Route::get('/stock-management/{id}/edit', [StockManagementController::class, 'edit'])->name('stock.edit');
Route::post('/stock-management/{id}/update', [StockManagementController::class, 'update'])->name('stock.update');
Route::post('/stock-management/{id}/delete', [StockManagementController::class, 'destroy'])->name('stock.destroy');
Route::post('/stock-management/bulk-delete', [StockManagementController::class, 'bulkDelete'])->name('stock.bulkDelete');
    
// Route Logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');