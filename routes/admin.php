<?php

use App\Http\Controllers\Admin\AuthorityManagement\PermissionController;
use App\Http\Controllers\Admin\AuthorityManagement\RoleController;
use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Categories\ChangeCategoryStatusController;
use App\Http\Controllers\Admin\Coupons\ChangeCouponStatusController;
use App\Http\Controllers\Admin\Coupons\CouponController;
use App\Http\Controllers\Admin\DailyOffers\DailyOfferController;
use App\Http\Controllers\Admin\DailyOffers\GetResourcesForDailyOfferFormController;
use App\Http\Controllers\Admin\ManageBlog\BlogCategoryController;
use App\Http\Controllers\Admin\ManageShipping\DeliveryAreaController;
use App\Http\Controllers\Admin\ManageShipping\ShippingMethodController;
use App\Http\Controllers\Admin\ProductReviews\ChangeProductReviewStatusController;
use App\Http\Controllers\Admin\ProductReviews\ProductReviewController;
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

        Route::apiResource('product-reviews', ProductReviewController::class)->only(["index","destroy"]);
        Route::put('/product-reviews/{product_review}/change-status', ChangeProductReviewStatusController::class)->middleware(['permission:product-reviews.edit']);

        Route::apiResource('daily-offers', DailyOfferController::class);
        Route::get('/resources/for-daily-offer', GetResourcesForDailyOfferFormController::class)->middleware(['permission:daily-offers.create','permission:daily-offers.edit']);

        Route::apiResource('coupons', CouponController::class);
        Route::put('/coupons/{coupon}/change-status', ChangeCouponStatusController::class)->middleware(['permission:coupons.edit']);

        Route::apiResource('delivery-areas', DeliveryAreaController::class);

        Route::apiResource('shipping-methods', ShippingMethodController::class);

        Route::apiResource('blog-categories', BlogCategoryController::class);

        Route::get('/permissions', [PermissionController::class, 'index']);

        Route::apiResource('roles', RoleController::class);
    });
