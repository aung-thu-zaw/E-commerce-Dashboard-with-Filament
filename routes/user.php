<?php

use App\Http\Controllers\User\MyAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->prefix('user')
    ->group(function () {
        Route::patch('/my-account', [MyAccountController::class, 'update']);
        Route::delete('/my-account', [MyAccountController::class, 'destroy']);
    });
