<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'shipping',
            'address1' => fake()->streetAddress(),
            'address2' => fake()->streetAddress(),
            'city' => fake()->city(),
            'county' => fake()->state(),
            'postcode' => fake()->postcode(),
            'customer_id' => fake()->numberBetween(1, 10),
            'country_code' => 'geo',
        ];
    }
}
