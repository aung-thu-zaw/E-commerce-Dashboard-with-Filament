<?php

namespace Database\Seeders;

use App\Models\ProductReviewResponse;
use Illuminate\Database\Seeder;

class ProductReviewResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductReviewResponse::factory(50)->create();
    }
}
