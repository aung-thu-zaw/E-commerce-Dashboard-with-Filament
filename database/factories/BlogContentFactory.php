<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogContent;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogContent>
 */
class BlogContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blogCategories = BlogCategory::pluck('id')->toArray();
        $authors = User::where('role', 'admin')->pluck('id')->toArray();

        return [
            'blog_category_id' => fake()->randomElement($blogCategories),
            'author_id' => fake()->randomElement($authors),
            'title' => fake()->unique()->sentence(),
            'thumbnail' => fake()->imageUrl(),
            'content' => fake()->paragraph(12),
            'status' => fake()->randomElement(['draft', 'published', 'hidden']),
            'created_at' => fake()->dateTimeBetween('-4 months', now()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (BlogContent $blogContent) {
            $tags = BlogTag::inRandomOrder()->limit(rand(1, 3))->get();
            $blogContent->blogTags()->attach($tags);
        });
    }
}
