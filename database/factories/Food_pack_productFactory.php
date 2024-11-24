<?php

namespace Database\Factories;

use App\Models\FoodPack;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\food_pack_product>
 */
class Food_pack_productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'food_pack_id' => fake()->randomElement(FoodPack::pluck('id')->toArray()),  // Random food_pack id
            'product_id' => fake()->randomElement(Product::pluck('id')->toArray()),      // Random product id
            'aantal_producten' => fake()->numberBetween(1, 10),  // Aantal producten in het voedselpakket
        ];
    }
}
