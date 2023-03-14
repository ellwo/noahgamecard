<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title'=>$this->faker->title,
            'body'=>$this->faker->text(150),
            'user_id'=>User::inRandomOrder()->pluck('id')->first(),
        ];
    }
}
