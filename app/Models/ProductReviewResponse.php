<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReviewResponse extends Model
{
    use HasFactory;

    public function productReview(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "response_by");
    }
}
