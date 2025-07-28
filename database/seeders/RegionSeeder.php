<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'North', 'code' => 'NORTH'],
            ['name' => 'South', 'code' => 'SOUTH'],
            ['name' => 'East', 'code' => 'EAST'],
            ['name' => 'West', 'code' => 'WEST'],
            ['name' => 'Central', 'code' => 'CENTRAL'],
        ];

        foreach ($regions as $region) {
            DB::table('regions')->updateOrInsert(
                ['code' => $region['code']],
                ['name' => $region['name'], 'code' => $region['code']]
            );
        }
    }
}
