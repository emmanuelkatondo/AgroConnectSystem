<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('districts')->insert([
            ['name' => 'Dodoma Urban', 'region_id' => 1],
            ['name' => 'mpwapwa', 'region_id' => 1],
            ['name' => 'Morogoro Urban', 'region_id' => 2],
            ['name' => 'kilosa', 'region_id' => 2],
            ['name' => 'Mbeya dc', 'region_id' => 3],
            ['name' => 'chunya', 'region_id' => 3],
        ]);
    }
}
