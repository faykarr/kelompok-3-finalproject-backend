<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::select('id')->get();
        foreach ($rooms as $room) {
            Facility::factory()->create([
                'room_id' => $room->id,
            ]);
        }
    }
}
