<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => User::factory(),

            'state' => fake()->state(),
            'country' => fake()->country(),
            'city' => fake()->city(),

            'street_address_1' => fake()->streetAddress(),
            'street_address_2' => fake()->optional()->secondaryAddress(),
        ];
    }
}
