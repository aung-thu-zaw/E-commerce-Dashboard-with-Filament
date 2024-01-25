<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductReview extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productReviewResponse(): HasOne
    {
        return $this->hasOne(productReviewResponse::class);
    }

    public function scopeSearch(Builder $query, ?string $searchTerm): Builder
    {
        return $query
            ->whereHas('reviewer', function ($subquery) use ($searchTerm) {
                $subquery->where('name', 'like', "%{$searchTerm}%");
            })
            ->orWhereHas('product', function ($subquery) use ($searchTerm) {
                $subquery->where('name', 'like', "%{$searchTerm}%");
            });
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['status']) && in_array($filterBy['status'], ['pending', 'published', 'hidden']), function ($query) use ($filterBy) {
                $query->where('status', $filterBy['status']);
            })
            ->when(isset($filterBy['response']) && in_array($filterBy['response'], ['awaiting', 'responded']), function ($query) use ($filterBy) {
                $query->where('response_status', $filterBy['response']);
            });
    }
}
