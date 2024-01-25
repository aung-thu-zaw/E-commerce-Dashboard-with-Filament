<?php

namespace Database\Seeders;

use App\Models\DeliveryArea;
use Illuminate\Database\Seeder;

class DeliveryAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryArea::create(['name' => 'Downtown Area']);
        DeliveryArea::create(['name' => 'Suburb A']);
        DeliveryArea::create(['name' => 'Suburb B']);
        DeliveryArea::create(['name' => 'Suburb C']);
        DeliveryArea::create(['name' => 'Suburb D']);
        DeliveryArea::create(['name' => 'Suburb E']);
        DeliveryArea::create(['name' => 'Suburb F']);
        DeliveryArea::create(['name' => 'Suburb G']);
        DeliveryArea::create(['name' => 'Suburb H']);
        DeliveryArea::create(['name' => 'Suburb I']);
    }
}
