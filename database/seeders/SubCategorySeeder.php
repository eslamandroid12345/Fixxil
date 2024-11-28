<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityUser;
use App\Models\SubCategory;
use App\Models\SubCategoryUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::factory(100)->create();
    }
}
