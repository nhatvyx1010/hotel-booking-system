<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'hotel_id' => null, // Gán khi tạo
            'name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'facebook' => $this->faker->url,
            'image' => 'upload/team/default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
