<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->all();
        $items = Item::pluck('id')->all();
        return [
            'item_id' => $items[array_rand($items)],
            'user_id' => $users[array_rand($users)],
            'detail' => $this->faker->realText(),
        ];
    }
}
