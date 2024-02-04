<?php

namespace App\Http\Controllers\Admin\MenuStocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuStockRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:menu-stocks.view', ['only' => ['index']]);
        $this->middleware('permission:menu-stocks.edit', ['only' => ['update']]);
    }

    public function index(): JsonResponse
    {
        try {
            $products = Product::search(request('search'))
                ->query(function (Builder $builder) {
                    $builder
                        ->filterBy(request(['sort', 'category','stock']))
                        ->sortBy(request('sort', 'latest'));
                })
                ->where("status", "published")
                ->paginate(request('per_page', 12))
                ->appends(request()->all());

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(MenuStockRequest $request, Product $product): JsonResponse
    {
        try {
            $product->update(["qty" => $request->qty,"is_available" => filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN)]);

            return response()->json($product, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
