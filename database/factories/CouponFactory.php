<?php

namespace Database\Factories;

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
        return [
            'code' => strtoupper(Str::random(8)),
            'description' => fake()->sentence,
            'type' => fake()->randomElement(['percentage', 'fixed', 'buy_one_get_one', 'free_item', 'special_event', 'online_ordering', 'birthday', 'referral', 'early_bird']),
            'discount_amount' => fake()->randomFloat(2, 5, 50),
            'minimum_order_amount' => fake()->numberBetween(20, 100),
            'free_item_quantity' => fake()->numberBetween(1, 5),
            'validity_period' => fake()->randomElement(['once', 'multiple', 'forever']),
            'start_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('+2 months', '+3 months')->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
