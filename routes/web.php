<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterOrderController;
use App\Http\Controllers\BaristaController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\RoleMiddleware;

// LOGIN
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/login');
});

// WAITERS
Route::prefix('waiters')->group(function () {
    Route::get('/tables', [WaiterOrderController::class, 'selectTable'])->name('waiters.table.select');
    Route::get('/table/{id}/order', [WaiterOrderController::class, 'create'])->name('waiters.order.create');
});

// ORDER (waiter simpan order)
Route::post('/orders/store-from-table', [OrderController::class, 'storeFromTable'])->name('orders.storeFromTable');

//BARISTA


//BARISTA
Route::middleware(['auth'])->group(function () {

    // Halaman utama barista
    Route::get('/barista/orders', [BaristaController::class, 'index'])
        ->name('barista.orders.index');

    // Filter tanggal (TARUH DI ATAS)
    Route::get('/barista/orders/filter', [BaristaController::class, 'filter'])
        ->name('barista.orders.filter');

    // Detail order
    Route::get('/barista/orders/{id}', [BaristaController::class, 'show'])
        ->name('barista.orders.show');

    // Update READY
    Route::post('/barista/orders/{id}/mark-ready', [BaristaController::class, 'markReady'])
        ->name('barista.orders.markReady');
});




// KASIR
Route::middleware(['auth', RoleMiddleware::class . ':kasir'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    Route::post('/transactions/{order}/pay', [TransactionController::class, 'pay'])
        ->name('transactions.pay');
});
