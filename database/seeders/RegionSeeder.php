<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared(file_get_contents('database/sql/wilayah_indonesia.sql'));

        DB::table('provinces')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('cities')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
