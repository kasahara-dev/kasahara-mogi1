<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::pluck('id');
        // Storage::fake('public');
        // $file = UploadedFile::fake()->image('img.jpeg', 100, 100);
        // $fileName = Str::uuid() . '.jpeg';
        // $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        return [
            'user_id' => $users->random(),
            'img_path' => 'img/item/yellow.png',
            'condition' => rand(1, 4),
            'name' => $this->faker->word(),
            'brand' => $this->faker->optional()->word(),
            'detail' => $this->faker->realText(),
            'price' => rand(0, 99999999),
        ];
    }
}
