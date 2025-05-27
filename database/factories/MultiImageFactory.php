<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MultiImage>
 */
class MultiImageFactory extends Factory
{
    protected $model = \App\Models\MultiImage::class;

    public function definition()
    {
        return [
            'rooms_id' => 1, // có thể override khi tạo
            'multi_img' => $this->faker->imageUrl(640, 480, 'hotel', true), // ảnh ngẫu nhiên
        ];
    }
}
