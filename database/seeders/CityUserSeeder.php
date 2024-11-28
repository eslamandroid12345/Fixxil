<?php

namespace Database\Seeders;

use App\Models\CityUser;
use App\Models\SubCategoryUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CityUser::factory(100)->create();
    }
}
