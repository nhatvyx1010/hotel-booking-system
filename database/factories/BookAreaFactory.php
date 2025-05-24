<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BookArea;

class BookAreaFactory extends Factory
{
    protected $model = BookArea::class;

    public function definition()
    {
        return [
            'image' => $this->faker->imageUrl(),
            'short_title' => $this->faker->words(3, true),
            'main_title' => $this->faker->sentence(),
            'short_desc' => $this->faker->paragraph(),
            'link_url' => $this->faker->url(),
        ];
    }
}
