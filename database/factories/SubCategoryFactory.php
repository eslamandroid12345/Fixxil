<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class SubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::query()->select('id')->inRandomOrder()->first();

        return [
            'name_ar' => $this->faker->name,
            'name_en' => $this->faker->name,
            'category_id' => $category->id,
            'is_active' => true,
        ];
    }
}
