<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('wards')->insert([
            ['name' => 'Kigogo', 'district_id' => 1],
            ['name' => 'Mlimani', 'district_id' => 1],
            ['name' => 'mipango', 'district_id' => 2],
            ['name' => 'machinga complex', 'district_id' => 2],
            ['name' => 'mafiga', 'district_id' => 3],
            ['name' => 'tungi', 'district_id' => 3],
            ['name' => 'kilosa kati', 'district_id' => 4],
            ['name' => 'nzovwe', 'district_id' => 5],
            ['name' => 'Igawilo', 'district_id' => 6],
        ]);
    }
}
