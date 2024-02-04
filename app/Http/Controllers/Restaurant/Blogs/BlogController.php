<?php

namespace App\Http\Controllers\Restaurant\Blogs;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $blogContents = BlogContent::with('blogCategory:id,name,slug')
                ->select('id', 'blog_category_id', 'thumbnail', 'title', 'slug', 'content')
                ->search(request('search'))
                ->filterBy(request(['category', 'tag']))
                ->where('status', 'published')
                ->sortBy(request('sort', 'latest'))
                ->paginate(12)
                ->withQueryString();

            return response()->json($blogContents, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(BlogContent $blogContent): JsonResponse
    {
        try {
            $blogContent->load(['author:id,name', 'blogCategory:id,name', 'blogTags:id,name']);

            $relatedBlogContents = BlogContent::select('id', 'thumbnail', 'title', 'slug', 'published_at')
                ->where('blog_category_id', $blogContent->blog_category_id)
                ->where('slug', '!=', $blogContent->slug)
                ->limit(10)
                ->get();

            $blogComments = BlogComment::with(['user:id,name,avatar', 'blogCommentResponses.user:id,name,avatar'])
                ->where('blog_content_id', $blogContent->id)
                ->orderBy('id', 'desc')
                ->paginate(5)
                ->withQueryString();

            return response()->json([
                "blog" => $blogContent,
                "relatedBlogs" => $relatedBlogContents,
                "comments" => $blogComments
            ], 200);

        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }

    //     // $shares = (new Share())
    //     //     ->currentPage("$blogContent->title")
    //     //     ->facebook()
    //     //     ->twitter()
    //     //     ->linkedIn()
    //     //     ->reddit()
    //     //     ->telegram()
    //     //     ->whatsApp()
    //     //     ->getRawLinks();
    }
}
