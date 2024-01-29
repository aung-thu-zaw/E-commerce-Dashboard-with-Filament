<?php

use App\Http\Controllers\AbilityController;
use App\Http\Controllers\Restaurant\Blogs\BlogCommentController;
use App\Http\Controllers\Restaurant\Blogs\BlogCommentReplyController;
use App\Http\Controllers\Restaurant\Blogs\BlogController;
use App\Http\Controllers\Restaurant\Blogs\GetResourcesForBlogPageController;
use App\Http\Controllers\Restaurant\ChefController;
use App\Http\Controllers\Restaurant\GetResourcesForHomePageController;
use App\Http\Controllers\Restaurant\SendContactEmailController;
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

Route::get('/chefs', [ChefController::class,"index"]);

Route::get('/blogs', [BlogController::class,"index"]);
Route::get('/blogs/{blog_content}', [BlogController::class,"show"]);
Route::get('/resources/for-blog-page', GetResourcesForBlogPageController::class);
Route::post('/blogs/{blog_content}/comments', BlogCommentController::class);
Route::post('/blogs/{blog_content}/comments/{blog_comment}/replies', BlogCommentReplyController::class);

Route::post('/contact/send-email', SendContactEmailController::class);

require __DIR__.'/admin.php';
