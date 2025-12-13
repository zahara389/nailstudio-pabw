<?php

// routes/api.php
use App\Http\Controllers\Api\ProductAPIController;
use Illuminate\Support\Facades\Route;

// Rute Resource dasar
Route::apiResource('products', ProductAPIController::class);

// Rute tambahan
Route::get('products/search/{keyword}', [ProductAPIController::class, 'search']);
Route::get('products/filter/category/{category}', [ProductAPIController::class, 'filterByCategory']);
Route::get('products/filter/status/{status}', [ProductAPIController::class, 'filterByStatus']);
Route::get('products/paginate', [ProductAPIController::class, 'paginate']);