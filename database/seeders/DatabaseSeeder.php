<?php

namespace Database\Seeders;

use App\Models\CityUser;
use App\Models\UseCategory;
use App\Models\Uses;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        Uses::factory(6)->create() ;
        $this->call([
//            UnitSeeder::class,
//            ManagerSeeder::class,
//            CategorySeeder::class,
//            SubCategorySeeder::class,
//            GovernorateSeeder::class,
//            CitySeeder::class,
//            ZoneSeeder::class,
            UserSeeder::class,
//            SubCategoryUserSeeder::class,
//            CityUserSeeder::class,
            UserFixedServiceSeeder::class,
            UserServiceImageSeeder::class,
//            BlogSeeder::class,
//            BlogImageSeeder::class,
//            RoleSeeder::class,
//            InfoSeeder::class,
//            StructureSeeder::class,
//            CustomerReviewSeeder::class,

        ]);
    }
}
