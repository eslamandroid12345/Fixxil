<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityUser;
use App\Models\SubCategoryUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory(30)->create();
    }
}
