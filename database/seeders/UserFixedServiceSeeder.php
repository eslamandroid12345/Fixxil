<?php

namespace Database\Seeders;

use App\Models\SubCategoryUser;
use App\Models\User;
use App\Models\UserFixedService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFixedServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFixedService::factory(100)->create();
    }
}
