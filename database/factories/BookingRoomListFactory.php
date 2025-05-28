<?php

namespace Database\Factories;

use App\Models\BookingRoomList;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingRoomListFactory extends Factory
{
    protected $model = BookingRoomList::class;

    public function definition()
    {
        return [
            'booking_id' => 1,
            'room_number_id' => 1,
            'room_id' => 1,
        ];
    }
}
