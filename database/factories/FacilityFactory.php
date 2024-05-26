<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bed' => $this->faker->numberBetween(1, 4),
            'bathroom' => $this->faker->numberBetween(1, 2),
            'balcony' => $this->faker->boolean(),
            'ac' => $this->faker->boolean(),
            'kitchen' => $this->faker->boolean(),
            'area' => $this->faker->randomFloat(1, 20, 100),
        ];
    }
}
