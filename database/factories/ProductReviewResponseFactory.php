<?php

namespace Database\Factories;

use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReviewResponse>
 */
class ProductReviewResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productReviews = ProductReview::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        return [
            'product_review_id' => fake()->randomElement($productReviews),
            'response_by' => fake()->randomElement($users),
            'response' => fake()->paragraph(),
        ];
    }
}
