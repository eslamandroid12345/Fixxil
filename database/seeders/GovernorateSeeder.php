<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityUser;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Governorate::factory(30)->create();
    }
}
