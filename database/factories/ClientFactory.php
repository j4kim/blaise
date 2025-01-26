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
        $gender = fake()->numberBetween(0, 1);
        return [
            'first_name' => fake()->firstName($gender ? 'male' : 'female'),
            'last_name' => fake()->lastName(),
            'gender' => $gender,
        ];
    }
}
