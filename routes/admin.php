<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');



// inventario
Route::resource('categories',CategoryController::class)->except(['show']);

Route::resource('products',ProductController::class)->except(['show']);

Route::post('products/{product}/dropzone',[ProductController::class,'dropzone'])->name('products.dropzone');

Route::resource('warehouses',\App\Http\Controllers\Admin\WarehouseController::class)->except(['show']);

Route::delete('images/{image}',[ImageController::class,'destroy'])->name('images.destroy');


//  compras
Route::resource('suppliers',\App\Http\Controllers\Admin\SupplierController::class)->except(['show']);

// clientes
Route::resource('customers',\App\Http\Controllers\Admin\CustomerController::class)->except(['show']);
Route::resource('purchase-orders',\App\Http\Controllers\Admin\PurchaseOrderController::class)->only(['index','create']);
