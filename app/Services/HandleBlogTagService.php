<?php

namespace App\Services;

use App\Models\BlogContent;
use App\Models\BlogTag;

class HandleBlogTagService
{
    /**
     * @param  array<string>  $tags
     */
    public function handle(array $tags, BlogContent $blogContent): void
    {
        $blogContent->blogTags()->detach();

        $filteredTags = array_unique(array_map('strtolower', $tags));

        $attachedTagIds = $blogContent->blogTags()->pluck('id')->toArray();

        foreach ($filteredTags as $tag) {
            $existedTag = BlogTag::where('name', $tag)->first();

            if (! $existedTag) {
                $tagModel = BlogTag::create(['name' => $tag]);

                $blogContent->blogTags()->attach($tagModel);
            } elseif (! in_array($existedTag->id, $attachedTagIds)) {
                $blogContent->blogTags()->attach($existedTag);
            }
        }
    }
}
