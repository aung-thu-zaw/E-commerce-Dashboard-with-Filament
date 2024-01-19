<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categories.view', ['only' => ['index']]);
        $this->middleware('permission:categories.create', ['only' => ['store']]);
        $this->middleware('permission:categories.edit', ['only' => ['update']]);
        $this->middleware('permission:categories.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $categories = Category::search(request('search'))
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($categories, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $category = Category::create($request->validated());
            return response()->json($category, 201);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $category->update($request->validated());
            return response()->json($category, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Category $category): Response
    {
        try {
            $category->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
