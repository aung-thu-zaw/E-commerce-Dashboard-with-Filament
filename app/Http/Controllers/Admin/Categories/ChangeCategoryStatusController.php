<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeCategoryStatusController extends Controller
{
    public function __invoke(Request $request, Category $category): JsonResponse
    {
        try {
            $request->validate(["status" => ['required', Rule::in(['true', 'false', true, false, 0, 1])]]);

            $category->update(["status" => filter_var($request->status, FILTER_VALIDATE_BOOLEAN)]);

            return response()->json($category, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
