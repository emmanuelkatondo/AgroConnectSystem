<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('regions')->insert([
            ['name' => 'Dodoma'],
            ['name' => 'Morogoro'],
            ['name' => 'Mbeya'],
        ]);
    }
}
