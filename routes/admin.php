<?php

use App\Http\Controllers\Admin\AuthorityManagement\PermissionController;
use App\Http\Controllers\Admin\AuthorityManagement\RoleController;
use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Categories\ChangeCategoryStatusController;
use App\Http\Controllers\Admin\Products\ChangeProductStatusController;
use App\Http\Controllers\Admin\Products\GetResourcesForProductFormController;
use App\Http\Controllers\Admin\Products\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::apiResource('categories', CategoryController::class);
        Route::put('/categories/{category}/change-status', ChangeCategoryStatusController::class)->middleware(['permission:categories.edit']);

        Route::apiResource('products', ProductController::class);
        Route::put('/products/{product}/change-status', ChangeProductStatusController::class)->middleware(['permission:products.edit']);
        Route::get('/resources/for-product', GetResourcesForProductFormController::class)->middleware(['permission:products.create','permission:products.edit']);

        Route::get('/permissions', [PermissionController::class, 'index']);

        Route::apiResource('roles', RoleController::class);
    });
