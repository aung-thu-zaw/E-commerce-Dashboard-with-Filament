<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Coupon extends Model
{
    use HasFactory;
    use HasSlug;
    use Searchable;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('code')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return array<string>
     */
    public function toSearchableArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'free_item_id');
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['status']) && in_array($filterBy['status'], ['active', 'inactive']), function ($query) use ($filterBy) {
                $query->where('status', $filterBy['status']);
            })
            ->when(isset($filterBy['type']) && in_array($filterBy['type'], ['percentage','fixed','free_item']), function ($query) use ($filterBy) {
                $query->where('type', $filterBy['type']);
            });
    }
}
