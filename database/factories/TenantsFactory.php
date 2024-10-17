<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenants>
 */
class TenantsFactory extends Factory
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
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'lease_start_date' => $this->faker->date(),
            'lease_end_date' => $this->faker->dateTimeBetween('+1 year', '+2 years')->format('Y-m-d'),
            'balance' => $this->faker->randomFloat(2, 0, 10000),  // balance between 0 and 10,000
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}

