<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create([
                    'role' => 'user',
                    ]),
            'hotel_id' => User::factory()->create([
                    'role' => 'hotel',
                    ]),
            'comment' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => 'approved',
        ];
    }
}
