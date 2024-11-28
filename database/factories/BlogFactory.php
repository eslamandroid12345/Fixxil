<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->select('id')->where('type', UserType::PROVIDER->value)->inRandomOrder()->first();
        $category = Category::query()->select('id')->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->title(),
            'content' => $this->faker->word(),
            'is_published' => true,
        ];
    }
}
