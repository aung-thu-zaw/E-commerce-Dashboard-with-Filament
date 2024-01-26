<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = Product::pluck("id")->toArray();

        return [
            'code' => strtoupper(Str::random(8)),
            'description' => fake()->sentence,
            'type' => fake()->randomElement(['percentage','fixed','free_item']),
            'discount_amount' => fake()->randomFloat(2, 5, 50),
            'minimum_order_amount' => fake()->numberBetween(20, 100),
            'free_item_id' => fake()->randomElement($products),
            'validity_period' => fake()->randomElement(['once', 'multiple', 'forever']),
            'start_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d'),
            'usage_limit' => fake()->numberBetween(10, 100),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
