<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Building;
use App\Models\Facility;
use App\Models\RoomImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::select('id')->get();
        foreach ($buildings as $building) {
            $building->rooms()->saveMany(Room::factory()->count(10)->make())
                ->each(function ($room) {
                    $room->roomFacility()->save(Facility::factory()->make());
                    $room->roomImages()->saveMany(RoomImage::factory()->count(6)->make());
                });

        }
    }
}
