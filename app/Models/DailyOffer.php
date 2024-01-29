<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyOffer extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->whereHas('product', function ($subquery) use ($searchTerm) {
            $subquery->where('name', 'like', "%{$searchTerm}%");
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($dailyOffer) {
            $discountedPrice = $dailyOffer->product->base_price * (1 - $dailyOffer->discount_percentage / 100);

            $dailyOffer->product->update(['discount_price' => $discountedPrice]);
        });
    }
}
