<?php

namespace App\Http\Controllers\Admin\ProductReviews;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeProductReviewStatusController extends Controller
{
    public function __invoke(Request $request, ProductReview $productReview): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['published', 'hidden'])]]);

            $productReview->load(['product:id,name,image', 'reviewer:id,name,avatar']);

            $productReview->update(['status' => $request->status]);

            return response()->json($productReview, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
