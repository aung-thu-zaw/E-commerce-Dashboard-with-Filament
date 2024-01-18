<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum', 'verified', 'admin'])
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::apiResource('categories', CategoryController::class)->except(['show']);

    });
