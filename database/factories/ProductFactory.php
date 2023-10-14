<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->words(rand(5, 15), true),
            'brand_id' => Brand::factory(),
            'description' => fake()->paragraph(),
            'image_url' => fake()->imageUrl(),
            'price' => fake()->numberBetween(1000, 10000),
        ];
    }
}
