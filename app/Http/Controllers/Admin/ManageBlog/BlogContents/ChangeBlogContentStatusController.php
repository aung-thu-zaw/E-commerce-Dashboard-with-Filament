<?php

namespace App\Http\Controllers\Admin\ManageBlog\BlogContents;

use App\Http\Controllers\Controller;
use App\Models\BlogContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeBlogContentStatusController extends Controller
{
    public function __invoke(Request $request, BlogContent $blogContent): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['published', 'hidden'])]]);

            if ($request->status === 'published') {

                $blogContent->update(['status' => $request->status, 'published_at' => now()]);

            } else {

                $blogContent->update(['status' => $request->status]);
            }

            $blogContent->load(['blogCategory:id,name', 'author:id,name']);

            return response()->json($blogContent, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
