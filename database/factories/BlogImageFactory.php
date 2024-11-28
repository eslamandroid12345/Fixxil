<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class BlogImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bolg = Blog::query()->select('id')->inRandomOrder()->first();
        return [
            'blog_id' => $bolg->id,
            'image' => $this->faker->imageUrl,
        ];
    }
}
