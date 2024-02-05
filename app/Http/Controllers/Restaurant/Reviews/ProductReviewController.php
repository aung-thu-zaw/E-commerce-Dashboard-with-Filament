<?php

namespace App\Http\Controllers\Restaurant\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\ProductReviewRequest;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function __invoke(ProductReviewRequest $request, Product $product): JsonResponse
    {
        try {
            $productReview = ProductReview::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]);

            return response()->json($productReview, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }

    }
}
