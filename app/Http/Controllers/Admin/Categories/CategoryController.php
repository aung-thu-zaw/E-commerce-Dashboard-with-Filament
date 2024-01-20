<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
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

    public function show(Category $category): JsonResponse
    {
        try {
            return response()->json($category, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        try {

            $validatedData = $request->validated();

            $validatedData['status'] = filter_var($validatedData['status'], FILTER_VALIDATE_BOOLEAN);

            $category = Category::create($validatedData);

            return response()->json($category, 201);

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $validatedData['status'] = filter_var($validatedData['status'], FILTER_VALIDATE_BOOLEAN);

            $category->update($validatedData);

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
