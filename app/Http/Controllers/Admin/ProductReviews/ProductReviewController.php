<?php

namespace App\Http\Controllers\Admin\ProductReviews;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-reviews.view', ['only' => ['index']]);
        $this->middleware('permission:product-reviews.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $productReviews = ProductReview::search(request('search'))
                ->with(['product:id,name,image', 'reviewer:id,name,avatar'])
                ->filterBy(request(['status', 'response']))
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($productReviews, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(ProductReview $productReview): Response
    {
        try {
            $productReview->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
