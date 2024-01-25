<?php

use App\Http\Controllers\Admin\AccountManagement\ChangeRegisteredAccountStatusController;
use App\Http\Controllers\Admin\AccountManagement\RegisteredAccountController;
use App\Http\Controllers\Admin\AuthorityManagement\PermissionController;
use App\Http\Controllers\Admin\AuthorityManagement\RoleController;
use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Categories\ChangeCategoryStatusController;
use App\Http\Controllers\Admin\Coupons\ChangeCouponStatusController;
use App\Http\Controllers\Admin\Coupons\CouponController;
use App\Http\Controllers\Admin\DailyOffers\DailyOfferController;
use App\Http\Controllers\Admin\DailyOffers\GetResourcesForDailyOfferFormController;
use App\Http\Controllers\Admin\ManageBlog\BlogCategoryController;
use App\Http\Controllers\Admin\ManageBlog\BlogCommentController;
use App\Http\Controllers\Admin\ManageBlog\BlogContents\BlogContentController;
use App\Http\Controllers\Admin\ManageBlog\BlogContents\ChangeBlogContentStatusController;
use App\Http\Controllers\Admin\ManageBlog\BlogContents\GetResourcesForBlogContentFormController;
use App\Http\Controllers\Admin\ManageReservation\ReservationTimeController;
use App\Http\Controllers\Admin\ManageReservation\TableController;
use App\Http\Controllers\Admin\ManageShipping\DeliveryAreaController;
use App\Http\Controllers\Admin\ManageShipping\ShippingMethodController;
use App\Http\Controllers\Admin\Newsletter\SendNewsletterController;
use App\Http\Controllers\Admin\Newsletter\SubscriberController;
use App\Http\Controllers\Admin\ProductReviews\ChangeProductReviewStatusController;
use App\Http\Controllers\Admin\ProductReviews\ProductReviewController;
use App\Http\Controllers\Admin\Products\ChangeProductStatusController;
use App\Http\Controllers\Admin\Products\DeleteProductAdditionalImageController;
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
        Route::get('/resources/for-product', GetResourcesForProductFormController::class)->middleware(['permission:products.create', 'permission:products.edit']);
        Route::delete('/products/additional-images/{additional_image}', DeleteProductAdditionalImageController::class);

        Route::apiResource('product-reviews', ProductReviewController::class)->only(['index', 'destroy']);
        Route::put('/product-reviews/{product_review}/change-status', ChangeProductReviewStatusController::class)->middleware(['permission:product-reviews.edit']);

        Route::apiResource('daily-offers', DailyOfferController::class);
        Route::get('/resources/for-daily-offer', GetResourcesForDailyOfferFormController::class)->middleware(['permission:daily-offers.create', 'permission:daily-offers.edit']);

        Route::apiResource('coupons', CouponController::class);
        Route::put('/coupons/{coupon}/change-status', ChangeCouponStatusController::class)->middleware(['permission:coupons.edit']);

        Route::apiResource('delivery-areas', DeliveryAreaController::class);

        Route::apiResource('shipping-methods', ShippingMethodController::class);

        Route::apiResource('tables', TableController::class);

        Route::apiResource('reservation-times', ReservationTimeController::class)->except(["show","update"]);

        Route::apiResource('blog-categories', BlogCategoryController::class);

        Route::apiResource('blog-contents', BlogContentController::class);
        Route::put('/blog-contents/{blog_content}/change-status', ChangeBlogContentStatusController::class)->middleware(['permission:blog-contents.edit']);
        Route::get('/resources/for-blog-content', GetResourcesForBlogContentFormController::class)->middleware(['permission:blog-contents.create', 'permission:blog-contents.edit']);

        Route::apiResource('blog-comments', BlogCommentController::class)->only(['index', 'destroy']);

        Route::apiResource('subscribers', SubscriberController::class)->only(['index', 'destroy']);

        Route::post('/send-newsletter', SendNewsletterController::class);

        // Route::apiResource('/registered-accounts', RegisteredAccountController::class)->only(["index","show","destroy"])->parameters(['registered_account' => 'user']);


        Route::get('/registered-accounts', [RegisteredAccountController::class,"index"]);
        Route::delete('/registered-accounts/{user}', [RegisteredAccountController::class,"destroy"]);
        Route::put('/registered-accounts/{user}/change-status', ChangeRegisteredAccountStatusController::class)->middleware(['permission:registered-accounts.edit']);

        Route::get('/permissions', [PermissionController::class, 'index']);

        Route::apiResource('roles', RoleController::class);
    });
