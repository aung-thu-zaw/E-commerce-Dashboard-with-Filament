<?php

namespace App\Http\Controllers\Admin\ManageBlog;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BlogCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:blog-comments.view', ['only' => ['index']]);
        $this->middleware('permission:blog-comments.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $blogComments = BlogComment::search(request('search'))
            ->with(['blogContent:id,title,thumbnail','user:id,name,avatar'])
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($blogComments, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(BlogComment $blogComment): Response
    {
        try {
            $blogComment->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
