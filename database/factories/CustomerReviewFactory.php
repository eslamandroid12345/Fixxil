<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CustomerReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_ar' => $this->faker->name(),
            'name_en' => $this->faker->name(),
            'job_title_ar' => $this->faker->title(),
            'job_title_en' => $this->faker->title(),
            'review_ar' => $this->faker->word(),
            'review_en' => $this->faker->word(),
            'image' => $this->faker->imageUrl,
        ];
    }
}
