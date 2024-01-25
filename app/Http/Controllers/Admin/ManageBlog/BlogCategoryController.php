<?php

namespace App\Http\Controllers\Admin\ManageBlog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageBlog\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-categories.view', ['only' => ['index']]);
        $this->middleware('permission:blog-categories.create', ['only' => ['store']]);
        $this->middleware('permission:blog-categories.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:blog-categories.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $blogCategories = BlogCategory::search(request('search'))
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($blogCategories, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(BlogCategoryRequest $request): JsonResponse
    {
        try {
            $blogCategory = BlogCategory::create($request->validated());

            return response()->json($blogCategory, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(BlogCategory $blogCategory): JsonResponse
    {
        try {
            return response()->json($blogCategory, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): JsonResponse
    {
        try {
            $blogCategory->update($request->validated());

            return response()->json($blogCategory, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(BlogCategory $blogCategory): Response
    {
        try {
            $blogCategory->delete();

            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
