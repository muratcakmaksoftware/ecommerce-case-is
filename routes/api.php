<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::resource("orders", OrderController::class)->only(['index', 'store', 'destroy']);
Route::delete("orders/product/{id}", [OrderController::class, 'destroyByProductId'])->name('orders.destroy_by_productId');
Route::get("orders/discount", [OrderController::class, 'discount'])->name('orders.discount');
