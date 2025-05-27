<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'rooms_id' => \App\Models\Room::factory(),
            'user_id' => \App\Models\User::factory(),
            'check_in' => $this->faker->date(),
            'check_out' => $this->faker->date(),
            'persion' => 2,
            'number_of_rooms' => 1,
            'total_night' => 1,
            'actual_price' => 100,
            'subtotal' => 100,
            'discount' => 0,
            'total_price' => 100,
            'payment_method' => 'cash',
            'transation_id' => null,
            'payment_status' => 'pending',
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'country' => 'Vietnam',
            'state' => 'Ho Chi Minh',
            'zip_code' => '700000',
            'address' => $this->faker->address,
            'code' => strtoupper($this->faker->lexify('???')),
            'status' => 1,
        ];
    }
}
