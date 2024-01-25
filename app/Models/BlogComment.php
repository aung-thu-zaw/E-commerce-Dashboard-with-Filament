<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogComment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blogContent(): BelongsTo
    {
        return $this->belongsTo(BlogContent::class);
    }

    public function blogCommentResponses(): HasMany
    {
        return $this->hasMany(BlogCommentResponse::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereHas('user', function ($subquery) use ($searchTerm) {
            $subquery->where('name', 'like', "%{$searchTerm}%");
        })
            ->orWhereHas('blogContent', function ($subquery) use ($searchTerm) {
                $subquery->where('title', 'like', "%{$searchTerm}%");
            });
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['response']) && in_array($filterBy['response'], ['awaiting', 'responded']), function ($query) use ($filterBy) {
                $query->where('response_status', $filterBy['response']);
            });
    }
}
