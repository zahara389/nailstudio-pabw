<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductAdminController;  
use App\Http\Controllers\AnalyticsController;     
use App\Http\Controllers\StockController;         
use App\Http\Controllers\FaqMessageController;   
use App\Http\Controllers\TransactionController;   
use App\Http\Controllers\StockManagementController; 
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;



// Route utama ke HomePage
Route::get('/', [HomePageController::class, 'index'])->name('home.index');

// Route untuk post booking
Route::post('/booking', [HomePageController::class, 'storeBooking'])->name('booking.store');

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

// UPDATE STOCK (PUT)
Route::put('/stock/{id}/update-stock', [StockManagementController::class, 'updateStock'])
        ->name('stock.updateStock');

// UPDATE HARGA (PUT)
Route::put('/stock/{id}/update-price', [StockManagementController::class, 'updatePrice'])
        ->name('stock.updatePrice');

// CREATE
Route::get('/stock-management/create', [StockManagementController::class, 'create'])->name('stock.create');
Route::post('/stock-management/store', [StockManagementController::class, 'store'])->name('stock.store');

// EDIT & UPDATE PRODUK
Route::get('/stock-management/{id}/edit', [StockManagementController::class, 'edit'])->name('stock.edit');
Route::post('/stock-management/{id}/update', [StockManagementController::class, 'update'])->name('stock.update');
Route::post('/stock-management/{id}/delete', [StockManagementController::class, 'destroy'])->name('stock.destroy');
Route::post('/stock-management/bulk-delete', [StockManagementController::class, 'bulkDelete'])->name('stock.bulkDelete');
    


//landing page 
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::put('/stock-management/{id}/update', [StockManagementController::class, 'update'])->name('stock.update');

// DELETE
Route::delete('/stock-management/{id}/delete', [StockManagementController::class, 'destroy'])->name('stock.destroy');
Route::delete('/stock-management/bulk-delete', [StockManagementController::class, 'bulkDelete'])->name('stock.bulkDelete');

// AUTHENTICATION ROUTES

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// REGISTER
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
