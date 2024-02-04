<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\BlogContent;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetResourcesForHomePageController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $popularFoods = Product::select("id", "category_id", "image", "name", "slug", "ingredients", "base_price", "discount_price")
            ->withPublishedReviewCount()
            ->withPublishedReviewAvg()
            ->where("status", "published")
            ->limit(12)
            ->latest()
            ->get();

            $ourChefs = Employee::whereHas('employeePosition', function ($query) {
                $query->where('name', 'like', '%Chef%');
            })
            ->select("id", "employee_position_id", "name", "image")
            ->with("employeePosition:id,name")
            ->where("status", "active")
            ->latest()
            ->limit(10)
            ->get();

            $latestBlogs = BlogContent::with('blogCategory:id,name,slug')
            ->select('id', 'blog_category_id', 'thumbnail', 'title', 'slug', 'content')
            ->where('status', 'published')
            ->latest()
            ->limit(10)
            ->get();

            return response()->json([
                    'popularFoods' => $popularFoods,
                    'ourChefs' => $ourChefs,
                    'latestBlogs' => $latestBlogs,
                ], 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
