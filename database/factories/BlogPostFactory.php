<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Models\User;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return [
            'blogcat_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'post_title' => $title,
            'post_slug' => Str::slug($title),
            'short_desc' => $this->faker->text(100),
            'long_desc' => $this->faker->paragraph(6),
            'post_image' => 'upload/post/dummy.jpg',
        ];
    }
}
