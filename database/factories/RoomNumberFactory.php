<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomNumber>
 */
class RoomNumberFactory extends Factory
{
    protected $model = \App\Models\RoomNumber::class;

    public function definition()
    {
        return [
            'rooms_id' => 1,  // có thể override khi dùng factory
            'room_type_id' => 1,  // tương tự
            'room_no' => $this->faker->unique()->numberBetween(100, 999), // số phòng giả
            'status' => $this->faker->randomElement(['available', 'booked', 'maintenance']), // trạng thái giả
        ];
    }
}
