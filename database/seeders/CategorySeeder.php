<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\CityUser;
use App\Models\SubCategoryUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(30)->create();
    }
}
