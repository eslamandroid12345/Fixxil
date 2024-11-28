<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = City::query()->select('id')->inRandomOrder()->first();
        return [
                    'name_ar' => $this->faker->city,
                    'name_en' => $this->faker->city,
                    'city_id' => $city->id,
                    'is_active' => true
                ];
    }
}
