<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'photo_name' => 'upload/gallery/' . $this->faker->uuid . '.jpg',
            'hotel_id' => rand(1, 10),
        ];
    }
}
