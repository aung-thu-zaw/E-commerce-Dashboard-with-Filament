<?php

use App\Http\Controllers\DownloadOrderInvoiceController;
use App\Http\Controllers\User\MyAccountController;
use App\Http\Controllers\User\MyOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->prefix('user')
    ->group(function () {
        Route::patch('/my-account', [MyAccountController::class, 'update']);
        Route::delete('/my-account', [MyAccountController::class, 'destroy']);

        Route::get('/my-orders', [MyOrderController::class,"index"]);
        Route::put('/my-orders/{order}/cancel', [MyOrderController::class,"update"]);
        Route::get('/my-orders/{order}/invoice/download', DownloadOrderInvoiceController::class);
    });
