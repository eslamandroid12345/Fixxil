<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::query()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '+96650000000',
            'password' => '123123123'
        ]);
        Manager::factory(4)->create();
    }
}
