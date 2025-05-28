<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class RoomBookedDateFactory extends Factory
{
    protected $model = \App\Models\RoomBookedDate::class;

    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'room_id' => Room::factory(),
            'book_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        ];
    }
}
