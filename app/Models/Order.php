<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'invoice_no' => $this->invoice_no,
            'order_no' => $this->order_no,
        ];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y', strtotime($value)),
        );
    }

    protected function purchasedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y', strtotime($value)),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['status']) && in_array($filterBy['status'], ['pending','confirmed', 'cancelled', 'on_delivery', 'delivered']), function ($query) use ($filterBy) {
                $query->where('status', $filterBy['status']);
            });
    }
}
