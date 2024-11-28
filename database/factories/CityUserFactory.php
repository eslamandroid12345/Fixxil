<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\City;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategoryUser>
 */
class CityUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = City::query()->select('id')->inRandomOrder()->first();
        $user = User::query()->select('id')->where('type', UserType::PROVIDER->value)->inRandomOrder()->first();

        return [
            'city_id' => $city->id,
            'user_id' => $user->id,
        ];
    }
}
