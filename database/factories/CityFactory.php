<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $governorate = Governorate::query()->select('id')->inRandomOrder()->first();
        return [
                    'name_ar' => $this->faker->city,
                    'name_en' => $this->faker->city,
                    'governorate_id' => $governorate->id,
                    'is_active' => true
                ];
    }
}
