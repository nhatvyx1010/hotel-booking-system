<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition()
    {
        $name = $this->faker->city;

        return [
            'name' => $name,
            'description' => $this->faker->paragraph,
            'image' => null,
            'slug' => Str::slug($name),
        ];
    }
}
