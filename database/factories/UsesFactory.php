<?php

namespace Database\Factories;

use App\Models\UseCategory;
use App\Models\Uses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Uses>
 */
class UsesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parentOrNot = $this->faker->boolean;
        return [
            'name_ar' => $this->faker->words(3, true),
            'name_en' => $this->faker->words(3, true),
            'video_link' => $parentOrNot ? $this->faker->optional()->url() : null,
            'description_en' => $this->faker->paragraph(),
            'description_ar' => $this->faker->paragraph(),
            'use_category_id' => $parentOrNot ? UseCategory::factory() : null,
            'parent_id' => !$parentOrNot ? Uses::factory() : null,
        ];
    }
}
