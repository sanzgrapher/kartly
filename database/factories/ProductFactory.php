<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => fake()->imageUrl(),
            'price' => fake()->numberBetween(100, 100000),
            'quantity' => fake()->numberBetween(0, 200),
            'description' => fake()->paragraph(),
            'category_id' => Category::factory(),
        ];
    }
}
