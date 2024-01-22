<?php

namespace App\Models;

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

    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereHas('reviewer', function ($subquery) use ($searchTerm) {
            $subquery->where('name', 'like', "%{$searchTerm}%");
        })
        ->orWhereHas('product', function ($subquery) use ($searchTerm) {
            $subquery->where('name', 'like', "%{$searchTerm}%");
        })
        ->orWhere('comment', 'like', "%{$searchTerm}%");
    }
}
