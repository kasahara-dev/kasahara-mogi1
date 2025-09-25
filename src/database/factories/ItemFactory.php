<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


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
        $conditions = array_keys(config('condition'));
        // Storage::fake('public');
        // $file = UploadedFile::fake()->image('img.jpeg', 100, 100);
        // $fileName = Str::uuid() . '.jpeg';
        // $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        return [
            'user_id' => $users->random(),
            'img_path' => 'img/item/yellow.png',
            'condition' => array_rand($conditions),
            'name' => $this->faker->word(),
            'brand' => $this->faker->optional()->word(),
            'detail' => $this->faker->realText(),
            'price' => rand(0, 99999999),
        ];
    }
}
