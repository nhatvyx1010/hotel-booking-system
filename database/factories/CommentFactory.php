<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => BlogPost::factory(),
            'message' => $this->faker->sentence(),
            'status' => 0,
        ];
    }
}
