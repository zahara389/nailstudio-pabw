<?php

// routes/api.php
use App\Http\Controllers\Api\ProductAPIController;
use App\Http\Controllers\Api\UsersApiController;
use Illuminate\Support\Facades\Route;

// Rute Resource dasar
Route::apiResource('products', ProductAPIController::class);

// Rute tambahan untuk products
Route::get('products/search/{keyword}', [ProductAPIController::class, 'search']);
Route::get('products/filter/category/{category}', [ProductAPIController::class, 'filterByCategory']);
Route::get('products/filter/status/{status}', [ProductAPIController::class, 'filterByStatus']);
Route::get('products/paginate', [ProductAPIController::class, 'paginate']);

// Rute Resource untuk users
Route::apiResource('users', UsersApiController::class);

// Rute tambahan untuk users
Route::get('users/paginate', [UsersApiController::class, 'paginate']);