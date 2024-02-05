<?php

namespace App\Http\Controllers\Restaurant\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\BlogCommentRequest;
use App\Models\BlogComment;
use App\Models\BlogContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function __invoke(BlogCommentRequest $request, BlogContent $blogContent): JsonResponse
    {
        try {
            $blogComment = BlogComment::create([
                'blog_content_id' => $blogContent->id,
                'user_id' => auth()->id(),
                'comment' => $request->comment,
            ]);

            return response()->json($blogComment, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }

    }
}
