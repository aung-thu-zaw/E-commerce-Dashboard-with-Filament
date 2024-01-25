<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogCategory::factory()->create(["name"=>"Recipe Corner"]);
        BlogCategory::factory()->create(["name"=>"Culinary Insights"]);
        BlogCategory::factory()->create(["name"=>"Ingredient Spotlight"]);
        BlogCategory::factory()->create(["name"=>"Taste of the World"]);
        BlogCategory::factory()->create(["name"=>"Behind the Kitchen"]);
    }
}
