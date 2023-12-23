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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'card_id' => $this->faker->numerify('################'),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'status' => $this->faker->boolean(),
        ];
    }
}