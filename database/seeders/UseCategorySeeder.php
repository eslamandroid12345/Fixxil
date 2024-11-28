<?php

namespace Database\Seeders;

use App\Models\UseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UseCategory::factory(10)->create();
    }
}
