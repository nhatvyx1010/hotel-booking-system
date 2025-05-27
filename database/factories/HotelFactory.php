<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'city_id' => City::factory(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->paragraph,
            'remember_token' => Str::random(10),
        ];
    }
}
