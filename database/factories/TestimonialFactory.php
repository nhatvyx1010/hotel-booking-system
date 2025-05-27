<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = \App\Models\Testimonial::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'city' => $this->faker->city(),
            'message' => $this->faker->sentence(),
            'image' => 'upload/team/default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
