<?php

namespace App\Http\Controllers\Admin\DailyOffers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class GetResourcesForDailyOfferFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $products = Product::select('id', 'name')->get();

            return response()->json($products, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
