<?php

namespace Database\Seeders;

use App\Models\SubCategoryUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategoryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategoryUser::factory(100)->create();
    }
}
