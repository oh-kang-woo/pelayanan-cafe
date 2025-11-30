<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// WAITER
Route::middleware(['auth', RoleMiddleware::class . ':waiter'])->group(function() {

    // pilih meja
    Route::get('/waiters/tables', [TableController::class, 'index'])
        ->name('waiters.table.select');

    // buat order dari meja
    Route::get('/waiters/order/create/{table}', [OrderController::class, 'createFromTable'])
        ->name('waiters.order.create');

    Route::post('/waiters/order/store', [OrderController::class, 'storeFromTable'])
        ->name('waiters.order.store');
});

// BARISTA
// BARISTA
Route::middleware(['auth'])->group(function () {
    Route::get('/barista/orders', [OrderController::class, 'baristaIndex'])->name('barista.orders.index');
    Route::get('/barista/orders/{id}', [OrderController::class, 'baristaShow'])->name('barista.orders.show');
    Route::post('/barista/orders/{id}/ready', [OrderController::class, 'setReady'])->name('barista.orders.ready');
});


// KASIR
Route::middleware(['auth', RoleMiddleware::class . ':kasir'])->group(function() {
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::post('/transactions/{order}/pay', [TransactionController::class, 'pay'])
        ->name('transactions.pay');
});
