<?php

// routes/api.php
use App\Http\Controllers\Api\ProductAPIController;
use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\Api\ProfileAPIController;
use Illuminate\Support\Facades\Route;

// Rute Resource dasar
Route::apiResource('products', ProductAPIController::class)->names('api.products');

// Rute tambahan untuk products
Route::get('products/search/{keyword}', [ProductAPIController::class, 'search']);
Route::get('products/filter/category/{category}', [ProductAPIController::class, 'filterByCategory']);
Route::get('products/filter/status/{status}', [ProductAPIController::class, 'filterByStatus']);
Route::get('products/paginate', [ProductAPIController::class, 'paginate']);

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