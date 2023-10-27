<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ManagerMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [OrderController::class, 'create']);

Route::get('/home', [OrderController::class, 'create'])->name('home');
Route::get('customers/all', [CustomerController::class, 'all'])->name("customers.all");
Route::get('products/all', [ProductController::class, 'all'])->name("products.all");

Route::middleware('auth')->group(function () {

    Route::get('/product-board', [OrderController::class, 'create'])->name("product-board");
    Route::post('orders/create', [OrderController::class, 'store'])->name("orders.store");
    Route::get('/orders/{order}/show', [OrderController::class, 'show'])->name("orders.show");
    Route::get('/orders/{order}/delete', [OrderController::class, 'destroy'])->name("orders.delete");

    Route::middleware([ManagerMiddleware::class])->group(function () {
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name("customers.index");
            Route::get('/create', [CustomerController::class, 'create'])->name("customers.create");
            Route::post('/create', [CustomerController::class, 'store'])->name("customers.store");    
            Route::get('/{customer}/show', [CustomerController::class, 'show'])->name("customers.show");    
            Route::put('/{customer}/update', [CustomerController::class, 'update'])->name("customers.update");
            Route::get('/{customer}/delete', [CustomerController::class, 'destroy'])->name("customers.delete");
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name("products.index");
            Route::get('/create', [ProductController::class, 'create'])->name("products.create");
            Route::post('/create', [ProductController::class, 'store'])->name("products.store");    
            Route::get('/{product}/show', [ProductController::class, 'show'])->name("products.show");    
            Route::put('/{product}/update', [ProductController::class, 'update'])->name("products.update");
            Route::get('/{product}/delete', [ProductController::class, 'destroy'])->name("products.delete");        
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name("users.index");
            Route::get('/create', [UserController::class, 'create'])->name("users.create");
            Route::post('/create', [UserController::class, 'store'])->name("users.store");    
            Route::get('/{user}/show', [UserController::class, 'show'])->name("users.show");    
            Route::put('/{user}/update', [UserController::class, 'update'])->name("users.update");
            Route::get('/{user}/delete', [UserController::class, 'destroy'])->name("users.delete");
        });
    });         
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name("orders.index");
    });
});

Auth::routes();

