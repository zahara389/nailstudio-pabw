<?php

// routes/api.php
use App\Http\Controllers\Api\ProductAPIController;
use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\Api\ProfileAPIController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\FaqApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\OrderApiController;

// Auth routes (public)
Route::post('login', [AuthApiController::class, 'login']);
Route::post('register', [AuthApiController::class, 'register']);

// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthApiController::class, 'logout']);

    // Profile API
    Route::prefix('profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileAPIController::class, 'show'])->name('show');
        Route::get('/addresses', [ProfileAPIController::class, 'addresses'])->name('addresses');
        Route::get('/orders', [ProfileAPIController::class, 'orders'])->name('orders');
    });

    // Other protected routes can be added here
});


// Rute tambahan untuk products (harus di atas resource route)
Route::get('products/search/{keyword}', [ProductAPIController::class, 'search']);
Route::get('products/filter/category/{category}', [ProductAPIController::class, 'filterByCategory']);
Route::get('products/filter/status/{status}', [ProductAPIController::class, 'filterByStatus']);
Route::get('products/paginate', [ProductAPIController::class, 'paginate']);

// Support category slug: /api/products/{category-slug}
Route::get('products/{category}', [ProductAPIController::class, 'filterByCategory'])
    ->where('category', '(nail-polish|nail-tools|nail-care|nail-kit)');

// Support detail produk dengan category dan slug: /api/products/{category}/{slug}
Route::get('products/{category}/{slug}', [ProductAPIController::class, 'showBySlug'])
    ->where('category', '(nail-polish|nail-tools|nail-care|nail-kit)')
    ->name('api.products.showBySlug');

// Rute Resource dasar (pastikan di bawah agar tidak override route custom)
Route::apiResource('products', ProductAPIController::class)
    ->names('api.products')
    ->except(['show']); // Exclude show karena bentrok dengan category route

// Show by ID (hanya numeric)
Route::get('products/{product}', [ProductAPIController::class, 'show'])
    ->where('product', '[0-9]+')
    ->name('api.products.show');

// Rute Resource untuk users
Route::apiResource('users', UsersApiController::class)->names('api.users');

// Rute tambahan untuk users
Route::get('users/paginate', [UsersApiController::class, 'paginate']);

// ================= PROFILE API =================
Route::prefix('profile')->name('api.profile.')->group(function () {
	Route::get('/', [ProfileAPIController::class, 'show'])->name('show');
	Route::get('/addresses', [ProfileAPIController::class, 'addresses'])->name('addresses');
	Route::get('/orders', [ProfileAPIController::class, 'orders'])->name('orders');
});

Route::get('jobs', [JobApiController::class, 'index']);
Route::get('jobs/{id}', [JobApiController::class, 'show']);

Route::post('jobs/apply', [JobApiController::class, 'apply']);
Route::get('jobs/{jobId}/applications', [JobApiController::class, 'applications']);

Route::get('bookings', [BookingApiController::class, 'index']);
Route::post('bookings', [BookingApiController::class, 'store']);

Route::get('faqs', [FaqApiController::class, 'index']);


use App\Http\Controllers\Api\CartApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('cart/add', [CartApiController::class, 'add']);
    Route::put('cart/item/{item}', [CartApiController::class, 'update']);
    Route::delete('cart/item/{item}', [CartApiController::class, 'delete']);
    Route::post('cart/checkout', [CartApiController::class, 'checkout']);
});
