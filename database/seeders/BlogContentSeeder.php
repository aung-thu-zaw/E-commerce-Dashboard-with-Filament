<?php

namespace Database\Seeders;

use App\Models\BlogContent;
use Illuminate\Database\Seeder;

class BlogContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BlogContent::factory(50)->create();

        BlogContent::factory()->create(["thumbnail" => 'blog-1.png','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-2.png','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-3.png','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-4.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-5.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-6.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-7.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-8.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-9.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-10.png','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-11.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-12.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-13.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-14.webp','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-15.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-16.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-17.png','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-18.jpg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-19.jpeg','status' => 'published','published_at' => now()]);
        BlogContent::factory()->create(["thumbnail" => 'blog-20.jpeg','status' => 'published','published_at' => now()]);
    }
}
