<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController; // Corrected: Removed unnecessary type hint
use App\Http\Controllers\Api\SalesController; // Corrected: Removed unnecessary type hint

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Product API routes
Route::apiResource('products', ProductController::class);

// Sales API routes
Route::apiResource('sales', SalesController::class);

// Custom routes if needed
// Route::get('/products/in-stock', [ProductController::class, 'inStock']);
// Route::post('/sales/{id}/add-product', [SalesController::class, 'addProduct']);
