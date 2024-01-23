<?php

namespace Database\Factories;

use App\Models\BlogComment;
use App\Models\BlogContent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCommentResponse>
 */
class BlogCommentResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blogComments = BlogComment::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        return [
            'blog_comment_id' => fake()->randomElement($blogComments),
            'user_id' => fake()->randomElement($users),
            'reply' => fake()->paragraph(),
        ];
    }
}
