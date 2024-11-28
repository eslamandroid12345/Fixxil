<?php

namespace Database\Factories;

use App\Http\Enums\UserType;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $governorate = Governorate::query()->select('id')->inRandomOrder()->first();
        $city = City::query()->select('id')->inRandomOrder()->first();
        $zone = Zone::query()->select('id')->inRandomOrder()->first();

        $type = $this->faker->randomElement([UserType::CUSTOMER->value, UserType::PROVIDER->value]);

        if ($type == UserType::CUSTOMER->value) {
            return [
                'type' => $type,
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => '123123123',
                'governorate_id' => $governorate->id,
                'city_id' => $city->id,
                'zone_id' => $zone->id,
                'address' => $this->faker->address,
                'phone' => $this->faker->e164PhoneNumber,
                'image' => $this->faker->imageUrl,
                'is_active' => true,
            ];
        } else {
            return [
                'type' => $type,
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => '123123123',
                'governorate_id' => $governorate->id,
                'city_id' => $city->id,
                'zone_id' => $zone->id,
                'address' => $this->faker->address,
                'phone' => $this->faker->e164PhoneNumber,
                'image' => $this->faker->imageUrl,
                'about' => $this->faker->text,
                'national_id' => $this->faker->numberBetween(10000000000000, 99999999999999),
                'national_id_image' => $this->faker->imageUrl,
                'criminal_record_sheet' => $this->faker->imageUrl,
                'is_active' => true,
                'is_verified' => true,
            ];
        }


    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
