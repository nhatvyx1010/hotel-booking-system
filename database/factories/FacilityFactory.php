<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    protected $model = \App\Models\Facility::class;

    public function definition()
    {
        return [
            'hotel_id' => 1,
            'rooms_id' => 1, // bạn có thể override khi gọi factory
            'facility_name' => $this->faker->word(), // tên facility ngẫu nhiên
        ];
    }
}
