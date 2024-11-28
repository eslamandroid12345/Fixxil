<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\SubCategory;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategoryUser>
 */
class UserFixedServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->select('id')->where('type', UserType::PROVIDER->value)->inRandomOrder()->first();
        $unit = Unit::query()->select('id')->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'name' => $this->faker->word,
            'price' => 499.99,
        ];
    }
}
