<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @return array<string>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => str_starts_with($value, 'http') || ! $value ? $value : asset("storage/employees/$value"),
        );
    }

    public function employeePosition(): BelongsTo
    {
        return $this->belongsTo(EmployeePosition::class);
    }

    public static function deleteImage(?string $image): void
    {
        if (! empty($image) && file_exists(storage_path('app/public/employees/'.pathinfo($image, PATHINFO_BASENAME)))) {
            unlink(storage_path('app/public/employees/'.pathinfo($image, PATHINFO_BASENAME)));
        }
    }

    public function scopeFilterBy(Builder $query, ?array $filterBy): Builder
    {
        return $query
            ->when(isset($filterBy['status']) && in_array($filterBy['status'], ['active', 'inactive']), function ($query) use ($filterBy) {
                $query->where('status', $filterBy['status']);
            })
            ->when(isset($filterBy['position']) && $filterBy['position'] !== '', function ($query) use ($filterBy) {
                $query->whereHas('employeePosition', function ($query) use ($filterBy) {
                    $query->where('slug', $filterBy['position']);
                });
            });
    }
}
