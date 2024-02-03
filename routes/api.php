<?php

use App\Http\Controllers\AbilityController;
use App\Http\Controllers\Restaurant\Blogs\BlogCommentController;
use App\Http\Controllers\Restaurant\Blogs\BlogCommentReplyController;
use App\Http\Controllers\Restaurant\Blogs\BlogController;
use App\Http\Controllers\Restaurant\Blogs\GetResourcesForBlogPageController;
use App\Http\Controllers\Restaurant\CartController;
use App\Http\Controllers\Restaurant\CartItemController;
use App\Http\Controllers\Restaurant\Checkout\CheckoutInformationController;
use App\Http\Controllers\Restaurant\Checkout\GetResourcesForCheckoutFormController;
use App\Http\Controllers\Restaurant\ChefController;
use App\Http\Controllers\Restaurant\GetResourcesForHomePageController;
use App\Http\Controllers\Restaurant\Menus\GetResourcesForMenuFilter;
use App\Http\Controllers\Restaurant\Menus\MenuController;
use App\Http\Controllers\Restaurant\SendContactEmailController;
use App\Http\Controllers\Restaurant\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user()->load('permissions:name');
});

Route::get('abilities', AbilityController::class);

Route::get('/resources/for-home', GetResourcesForHomePageController::class);

Route::get('/menus', [MenuController::class,"index"]);
Route::get('/menus/{product}', [MenuController::class,"show"]);
Route::get('/resources/for-menu-filter', GetResourcesForMenuFilter::class);

Route::get('/chefs', [ChefController::class,"index"]);

Route::get('/blogs', [BlogController::class,"index"]);
Route::get('/blogs/{blog_content}', [BlogController::class,"show"]);
Route::get('/resources/for-blog-page', GetResourcesForBlogPageController::class);
Route::post('/blogs/{blog_content}/comments', BlogCommentController::class);
Route::post('/blogs/{blog_content}/comments/{blog_comment}/replies', BlogCommentReplyController::class);

Route::post('/contact/send-email', SendContactEmailController::class);

Route::resource('/wishlists', WishlistController::class)->only(['index','store', 'destroy']);

Route::get('/cart', CartController::class);
Route::post('/cart/cart-items', [CartItemController::class,'store']);
Route::patch('/cart/cart-items/{cart_item}', [CartItemController::class,'update']);
Route::delete('/cart/cart-items/{cart_item}', [CartItemController::class,'destroy']);

Route::get('/resources/for-checkout', GetResourcesForCheckoutFormController::class);
Route::get('/checkout/get-information', [CheckoutInformationController::class,"index"]);
Route::post('/checkout/store-information', [CheckoutInformationController::class,"store"]);

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
