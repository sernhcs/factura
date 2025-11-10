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
Route::resource('purchase-orders',\App\Http\Controllers\Admin\PurchaseOrderController::class)->only(['index','create']);
Route::resource('purchases',\App\Http\Controllers\Admin\PurchaseController::class)->only(['index','create']);

// clientes
Route::resource('customers',\App\Http\Controllers\Admin\CustomerController::class)->except(['show']);


// ventas
Route::resource('quotes',\App\Http\Controllers\Admin\QuoteController::class)->only(['index','create']);
Route::resource('sales',\App\Http\Controllers\Admin\SaleController::class)->only(['index','create']);

// movimientos
Route::resource('movements',\App\Http\Controllers\Admin\MovementController::class)->only(['index','create']);

// Transferencias
Route::resource('transfers',\App\Http\Controllers\Admin\TransferController::class)->only(['index','create']);
