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
        Storage::fake('public');
        $file = UploadedFile::fake()->create('contactTest.jpg', 100, 'image/jpeg');
        $fileName = Str::uuid() . '.jpeg';
        $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        return [
            'user_id' => $users->random(),
            'img_path' => 'storage/' . $path,
            'condition' => array_rand($conditions),
            'name' => $this->faker->sentence(),
            'brand' => $this->faker->optional()->sentence(),
            'detail' => $this->faker->realText(),
            'price' => $this->faker->randomNumber(8),
        ];
    }
}
