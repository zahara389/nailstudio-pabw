<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqMessageController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockManagementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;




Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
// Halaman Metode Pembayaran (Payment Options)
Route::get('/payment-options', function () {
    return view('landing_page.payment');
})->name('payment.index');

Route::get('/about-us', function () {
    return view('landing_page.aboute');
})->name('about.index');

// Route untuk nampilin halaman
Route::get('/customer-service', [CustomerServiceController::class, 'index'])->name('about');

// Route untuk PROSES kirim pesan (Tambahkan baris ini!)
Route::post('/customer-service/send', [CustomerServiceController::class, 'store'])->name('contact.send');



Route::get('/products/{category?}', [ProductController::class, 'index'])
    ->where('category', '(nail-polish|nail-tools|nail-care|nail-kit)')
    ->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// LOGIN REGISTER
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// ======================= ROUTE DENGAN AUTH =======================
Route::middleware('auth')->group(function () {

    // BOOKING (WAJIB LOGIN)
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.updateStatus');
    Route::get('/dashboard/orders/{id}', [DashboardController::class, 'showDetail'])->name('dashboard.orders.show');

    Route::resource('product', ProductAdminController::class)
        ->parameters(['product' => 'id'])
        ->names('product');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::prefix('admin/faq')->name('admin.faq.')->group(function () {
        Route::get('/', [FaqMessageController::class, 'index'])->name('index');
        Route::post('/', [FaqMessageController::class, 'store'])->name('store');
        Route::get('/{id}', [FaqMessageController::class, 'show'])->name('show');
        Route::put('/{id}', [FaqMessageController::class, 'update'])->name('update');
        Route::delete('/{id}', [FaqMessageController::class, 'destroy'])->name('destroy');
        Route::post('/submit-answer', [FaqMessageController::class, 'submitAnswer'])->name('submit');
    });

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/history', [TransactionController::class, 'index'])->name('history');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    // User Order History
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [\App\Http\Controllers\OrderHistoryController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\OrderHistoryController::class, 'show'])->name('show');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/items', [CartController::class, 'store'])->name('items.store');
        Route::patch('/items/{item}', [CartController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}', [CartController::class, 'destroy'])->name('items.destroy');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/pay', [CartController::class, 'processCheckout'])->name('checkout.process');
        Route::post('/checkout/qris', [CartController::class, 'processQrisPayment'])->name('checkout.qris');
    });

    // Payment success page
    Route::get('/payment-success', function () {
        return view('payment.success');
    })->name('payment.success');

    // Address Routes
    Route::prefix('address')->name('address.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('stock-management')->name('stock.')->group(function () {
        Route::get('/', [StockManagementController::class, 'index'])->name('index');
        Route::get('/create', [StockManagementController::class, 'create'])->name('create');
        Route::post('/', [StockManagementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StockManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StockManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [StockManagementController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/update-stock', [StockManagementController::class, 'updateStock'])->name('updateStock');
        Route::put('/{id}/update-price', [StockManagementController::class, 'updatePrice'])->name('updatePrice');
        Route::post('/bulk-delete', [StockManagementController::class, 'bulkDelete'])->name('bulkDelete');
    });

    // Halaman Profile: render UI langsung
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Opsi eksplisit tetap ada jika diperlukan
    Route::get('/profile/view', [ProfileController::class, 'index'])->name('profile.view');
});


// ===================== RUTE LOWONGAN PEKERJAAN PUBLIK =====================

// Rute melihat lowongan
Route::prefix('lowongan')->group(function () {
    Route::get('/', [JobController::class, 'publicIndex'])->name('lowongan.index');
    Route::get('/{job}', [JobController::class, 'show'])->name('lowongan.show');
});

// Form dan Submit
Route::get('/apply/{jobId}', [JobController::class, 'showApplicationForm'])->name('job.apply');
Route::post('/apply', [JobController::class, 'storeApplication'])->name('job.submit');

// Akses publik ke admin lowongan
Route::prefix('admin/jobs')->name('job.')->group(function () {
Route::get('/', [JobController::class, 'index'])->name('index'); 
Route::get('/create', [JobController::class, 'create'])->name('create');
Route::post('/', [JobController::class, 'store'])->name('store');
Route::get('/{id}', [JobController::class, 'showAdmin'])->name('show'); 
Route::get('/{id}/edit', [JobController::class, 'edit'])->name('edit');
Route::put('/{id}', [JobController::class, 'update'])->name('update');
Route::delete('/{id}', [JobController::class, 'destroy'])->name('destroy');
    });        
       
       

Route::post('/test-post', function () {
    return response('TEST BERHASIL WEB ROUTE', 200);
});

