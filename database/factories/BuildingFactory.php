<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\BuildingType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $buildingTypeId = BuildingType::pluck('id')->toArray();
        $cityId = City::pluck('id')->toArray();

        return [
            'building_type_id' => $this->faker->randomElement($buildingTypeId),
            'city_id' => $this->faker->randomElement($cityId),
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
