<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ReservationTime extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @return array<string>
     */
    public function toSearchableArray(): array
    {
        return [
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }

    protected function startTime(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::createFromTime($value['hours'], $value['minutes'], $value['seconds']),
        );
    }

    protected function endTime(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::createFromTime($value['hours'], $value['minutes'], $value['seconds']),
        );
    }
}
