<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = Product::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($users),
            'product_id' => fake()->randomElement($products),
            'comment' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement(['pending', 'published', 'hidden']),
            'response_status' => fake()->randomElement(['awaiting', 'responded']),
        ];
    }
}
