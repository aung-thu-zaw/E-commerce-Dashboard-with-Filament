<?php

namespace App\Http\Controllers\Admin\ManageBlog\BlogContents;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;

class GetResourcesForBlogContentFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $blogCategories = BlogCategory::select('id', 'name', 'slug')->get();

            return response()->json($blogCategories, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
