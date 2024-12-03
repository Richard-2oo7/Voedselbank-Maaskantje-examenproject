<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => fake()->randomElement(Role::pluck('id')->toArray()), //random role id
            'naam' => fake()->name(),
            'gebruikersnaam' => fake()->name(),
            'email' => fake()->email(),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }
}
