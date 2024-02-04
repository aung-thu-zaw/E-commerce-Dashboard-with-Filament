<?php

namespace App\Http\Controllers\Restaurant\Menus;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $products = Product::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder
                        ->select('id', 'category_id', 'image', 'name', 'slug', 'ingredients', 'base_price', 'discount_price')
                        ->filterBy(request(['rating', 'category']))
                        ->withPublishedReviewCount()
                        ->withPublishedReviewAvg()
                        ->sortBy(request('sort', 'latest'));
                })
                ->where('status', 'published')
                ->paginate(16)
                ->appends(request()->all());

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Product $product): JsonResponse
    {
        try {
            $product->load([
                'additionalImages:id,product_id,image',
                'addons:id,product_id,name,additional_price',
            ]);

            $product->loadAvg(['productReviews' => function ($query) {
                $query->where('status', 'published');
            }], 'rating');

            $product->loadCount(['productReviews' => function ($query) {
                $query->where('status', 'published');
            }]);

            $relatedItems = Product::select('id', 'category_id', 'image', 'name', 'slug', 'ingredients', 'base_price', 'discount_price')
            ->withPublishedReviewCount()
            ->withPublishedReviewAvg()
            ->where('category_id', $product->category_id)
            ->where('slug', '!=', $product->slug)
            ->limit(15)
            ->get();

            return response()->json(
                [
                    'product' => $product,
                    "relatedItems" => $relatedItems,
                    // "comments" => $blogComments
                ],
                200,
            );
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
