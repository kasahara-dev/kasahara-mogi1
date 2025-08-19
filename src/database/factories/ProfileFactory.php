<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Address;
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id')->all();
        $addresses = Address::pluck('id')->all();
        return [
            'user_id' => $users[array_rand($users)]->unique(),
            'address_id' => $addresses[array_rand($addresses)],
        ];
    }
}
