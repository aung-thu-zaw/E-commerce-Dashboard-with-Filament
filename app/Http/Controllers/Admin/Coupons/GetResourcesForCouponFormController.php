<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetResourcesForCouponFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $products = Product::select('id', 'name', 'slug')->get();

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
