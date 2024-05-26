<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Building;
use App\Models\BuildingImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::select('id')->where('role', 'owner')->get();
        foreach ($users as $user) {
            $building = Building::factory()->create([
                'user_id' => $user->id,
            ]);
            $building->buildingImages()->saveMany(BuildingImage::factory()->count(6)->make());
        }
    }
}
