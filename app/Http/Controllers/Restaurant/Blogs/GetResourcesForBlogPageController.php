<?php

namespace App\Http\Controllers\Restaurant\Blogs;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetResourcesForBlogPageController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $blogCategories = BlogCategory::select('id', 'name', 'slug')->withCount("blogContents")->get();

            $blogTags = BlogTag::select("id", "name")->get();

            return response()->json([
                "categories" => $blogCategories,
                "tags" => $blogTags,
            ], 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
