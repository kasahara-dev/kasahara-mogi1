<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $purchase = Purchase::inRandomOrder()->first();
        $item = $purchase->item()->get();
        $seller = $purchase->item->user->id;
        $users = [$seller,$purchase->user->id];
        return [
            'purchase_id' => $purchase->id,
            'user_id' => $users[rand(0,1)],
            'detail' => $this->faker->realText(),
        ];
    }
}
