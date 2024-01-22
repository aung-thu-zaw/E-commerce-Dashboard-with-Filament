<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeProductStatusController extends Controller
{
    public function __invoke(Request $request, Product $product): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['draft','published'])]]);

            $product->update(['status' => $request->status]);

            return response()->json($product, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
