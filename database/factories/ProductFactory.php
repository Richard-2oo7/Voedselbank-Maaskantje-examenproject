<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'EAN' => fake()->unique()->regexify('[0-9]{13}'), // Alleen cijfers, 13 karakters
            'category_id' => fake()->randomElement(Category::pluck('id')->toArray()), //random categorie id
            'naam' => fake()->word(),
            'aantal' => fake()->numberBetween(0,15),
        ];
    }
}
