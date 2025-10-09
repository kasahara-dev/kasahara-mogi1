<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id');
        $items = Item::pluck('id');
        return [
            'item_id' => $items->random(),
            'user_id' => $users->random(),
            'user_name' => $this->faker->name(),
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ];
    }
}
