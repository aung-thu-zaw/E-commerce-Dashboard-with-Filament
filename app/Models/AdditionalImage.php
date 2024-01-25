<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdditionalImage extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str_starts_with($value, 'http') || ! $value ? $value : asset("storage/products/$value"),
        );
    }

    public static function deleteImage(string $productImage): void
    {
        if (! empty($productImage) && file_exists(storage_path('app/public/products/'.pathinfo($productImage, PATHINFO_BASENAME)))) {
            unlink(storage_path('app/public/products/'.pathinfo($productImage, PATHINFO_BASENAME)));
        }
    }
}
