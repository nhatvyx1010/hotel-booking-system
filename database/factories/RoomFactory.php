<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'hotel_id' => \App\Models\User::factory(),
            'roomtype_id' => 1,
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'image' => 'room.jpg',
            'price' => 100,
            'size' => 30,
            'view' => 'city',
            'bed_style' => 'twin',
            'discount' => 0,
            'short_desc' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 1,
        ];
    }
}
