<?php

namespace App\Http\Controllers\Admin\ManageBlog\BlogContents;

use App\Actions\Admin\BlogContents\CreateBlogContentAction;
use App\Actions\Admin\BlogContents\UpdateBlogContentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageBlog\BlogContentRequest;
use App\Models\BlogContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BlogContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-contents.view', ['only' => ['index']]);
        $this->middleware('permission:blog-contents.create', ['only' => ['store']]);
        $this->middleware('permission:blog-contents.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:blog-contents.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $blogContents = BlogContent::search(request('search'))
                ->with(['blogCategory:id,name', 'author:id,name'])
                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                ->paginate(request('per_page', 5))
                ->appends(request()->all());

            return response()->json($blogContents, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(BlogContentRequest $request): JsonResponse
    {
        try {
            $blogContent = (new CreateBlogContentAction())->handle($request->validated());
            return response()->json($blogContent, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(BlogContent $blogContent): JsonResponse
    {
        try {
            $blogContent->load(['blogTags']);
            return response()->json($blogContent, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(BlogContentRequest $request, BlogContent $blogContent): JsonResponse
    {
        try {
            $blogContent = (new UpdateBlogContentAction())->handle($request->validated(), $blogContent);
            return response()->json($blogContent, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(BlogContent $blogContent): Response
    {
        try {
            $blogContent->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
