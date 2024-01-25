<?php

namespace Database\Factories;

use App\Models\BlogContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogComment>
 */
class BlogCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blogContents = BlogContent::pluck('id')->toArray();
        $users = User::where('role', 'user')->pluck('id')->toArray();

        return [
            'blog_content_id' => fake()->randomElement($blogContents),
            'user_id' => fake()->randomElement($users),
            'comment' => fake()->paragraph(),
            'response_status' => fake()->randomElement(['awaiting', 'responded']),
            'created_at' => fake()->dateTimeBetween('-1 months', now()),
        ];
    }
}
