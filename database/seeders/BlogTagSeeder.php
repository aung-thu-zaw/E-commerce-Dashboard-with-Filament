<?php

namespace Database\Seeders;

use App\Models\BlogTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogTag::create(["name" => "CuisineInspiration"]);
        BlogTag::create(["name" => "GourmetDelights"]);
        BlogTag::create(["name" => "FoodieAdventures"]);
        BlogTag::create(["name" => "LocalFlavors"]);
        BlogTag::create(["name" => "ChefSpotlight"]);
        BlogTag::create(["name" => "TastyTrends"]);
        BlogTag::create(["name" => "HealthyEats"]);
        BlogTag::create(["name" => "DiningOut"]);
        BlogTag::create(["name" => "FoodFestivals"]);
        BlogTag::create(["name" => "SustainableDining"]);
        BlogTag::create(["name" => "RecipeShare"]);
        BlogTag::create(["name" => "CulinaryJourney"]);
        BlogTag::create(["name" => "FarmToTable"]);
        BlogTag::create(["name" => "StreetFoodScene"]);
        BlogTag::create(["name" => "DessertHeaven"]);
    }
}
