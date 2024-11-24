<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodPack>
 */
class FoodPackFactory extends Factory
{
    /**
     * Define the model's default state.
     *  
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => fake()->randomElement(Client::pluck('id')->toArray()), //random client id
            'datum_samenstelling' => fake()->dateTime(),
            'uitgiftedatum' => fake()->dateTime(),
            'opgehaald' => false 
        ];
    }
}
