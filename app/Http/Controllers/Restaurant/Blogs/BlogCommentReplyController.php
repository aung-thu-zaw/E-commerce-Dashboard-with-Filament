<?php

namespace App\Http\Controllers\Restaurant\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\BlogCommentReplyRequest;
use App\Models\BlogComment;
use App\Models\BlogCommentResponse;
use App\Models\BlogContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogCommentReplyController extends Controller
{
    public function __invoke(BlogCommentReplyRequest $request, BlogContent $blogContent, BlogComment $blogComment): JsonResponse
    {
        try {
            $blogCommentReply = BlogCommentResponse::create([
                'blog_comment_id' => $blogComment->id,
                'user_id' => auth()->id(),
                'reply' => $request->reply,
            ]);

            return response()->json($blogCommentReply, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
