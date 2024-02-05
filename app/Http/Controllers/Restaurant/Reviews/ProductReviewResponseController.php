<?php

namespace App\Http\Controllers\Restaurant\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductReviewResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductReviewResponseController extends Controller
{
    public function __invoke(Request $request, Product $product, ProductReview $productReview): JsonResponse
    {
        try {
            $productReviewReply = ProductReviewResponse::create([
                'product_review_id' => $productReview->id,
                'response_by' => auth()->id(),
                'response' => $request->response
            ]);

            return response()->json($productReviewReply, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
