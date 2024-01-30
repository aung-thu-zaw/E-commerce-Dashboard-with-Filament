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
                        ->select('id', 'category_id', 'image', 'name', 'ingredients', 'base_price', 'discount_price')
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
}
