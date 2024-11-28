<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategoryUser>
 */
class SubCategoryUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subCategory = SubCategory::query()->select('id')->inRandomOrder()->first();
        $user = User::query()->select('id')->where('type', UserType::PROVIDER->value)->inRandomOrder()->first();

        return [
            'sub_category_id' => $subCategory->id,
            'user_id' => $user->id,
        ];
    }
}
