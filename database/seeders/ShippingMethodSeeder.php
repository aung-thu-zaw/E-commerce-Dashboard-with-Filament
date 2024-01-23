<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingMethod::create(["name" => "Standard Delivery","cost" => 5.00]);
        ShippingMethod::create(["name" => "Express Delivery","cost" => 10.00]);
        ShippingMethod::create(["name" => "Pickup","cost" => 0.00]);
    }
}
