<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\channels;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Channel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
//            'image' => $this->faker->image(),
            'description' => $this->faker->realText(255),
            'user_id' => User::factory(),
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
