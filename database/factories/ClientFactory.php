<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gezinsnaam' => fake()->lastName(),
            'postcode' => fake()->postcode(),
            'adres' => fake()->streetAddress(),
            'email' => fake()->unique()->safeEmail(),
            'telefoonnummer' => fake()->phoneNumber(),
            'volwassenen' => fake()->numberBetween(1, 5),
            'kinderen' => fake()->numberBetween(0, 4),
            'babys' => fake()->numberBetween(0, 2),
            'is_klant' => fake()->boolean(90),          // 90% kans dat 'is_klant' true is
        ];
    }
}
