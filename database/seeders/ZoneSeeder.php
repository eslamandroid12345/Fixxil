<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Zone;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Zone::factory(30)->create();
    }
}
