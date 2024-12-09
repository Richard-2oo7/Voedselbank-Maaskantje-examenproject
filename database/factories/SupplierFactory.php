<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bedrijfsnaam' => fake()->company(),
            'naam' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefoonnummer' => fake()->phoneNumber(),
            'adres' => fake()->address(),
            'locatie' => fake()->randomElement(['Almere', 'Nieuwegein', 'Lelystad']),
            'volgende_levering' => fake()->dateTime(),
        ];
    }
}
