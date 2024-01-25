<?php

namespace Database\Seeders;

use App\Models\DailyOffer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyOffer::factory(20)->create();
    }
}
