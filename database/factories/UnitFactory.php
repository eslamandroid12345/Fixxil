<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                    'name_en' => $this->faker->name,
                    'name_ar' => $this->faker->name,
                    'is_active' => true,
                ];
    }
}
