<?php

namespace Database\Seeders;

use App\Models\SubCategoryUser;
use App\Models\User;
use App\Models\UserFixedService;
use App\Models\UserServiceImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserServiceImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserServiceImage::factory(100)->create();
    }
}
