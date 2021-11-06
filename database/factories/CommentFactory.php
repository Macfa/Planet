<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\comments;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "post_id" => Post::factory(),
            "group" => 1,
            "content" => $this->faker->text,
            "user_id" => User::factory(),
            "depth" => 1,
            "order" => 1,
        ];
    }
}
