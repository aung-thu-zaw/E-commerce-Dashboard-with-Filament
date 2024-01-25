<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyOffer>
 */
class DailyOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = Product::pluck('id')->toArray();

        return [
            'product_id' => fake()->randomElement($products),
            'start_date' => fake()->dateTimeBetween(now(), '+7 days'),
            'end_date' => fake()->dateTimeBetween('+7 days', '+ 14 days'),
            'discount_percentage' => fake()->numberBetween(5, 50),
        ];
    }
}
