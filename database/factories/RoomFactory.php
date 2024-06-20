<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'capacity' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->numberBetween(500000, 2000000),
            'description' => $this->faker->text,
            'is_available' => $this->faker->boolean(),
        ];
    }
}
