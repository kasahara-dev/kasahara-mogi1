<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use Faker\Factory;
use Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Database\Seeders\CategoriesTableSeeder;

class Case15SellTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sell()
    {
        $this->seed(CategoriesTableSeeder::class);

        $faker = Factory::create('ja_JP');
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);
        $conditions = array_keys(config('condition'));
        Storage::fake('public');
        $file = UploadedFile::fake()->image('img.jpeg', 100, 100);
        $fileName = Str::uuid() . '.jpeg';
        $path = Storage::disk('public')->putFileAs('item', $file, $fileName);

        // $file = $request->file('item_img_input');
        // $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        // $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        $this->assertEquals(0, Item::count());

        $category[] = '1';
        $response = $this->actingAs($user)->post('/sell', [
            'item_img_input' => $file,
            'condition' => array_rand($conditions),
            'itemName' => $faker->unique()->word(),
            'brandName' => $faker->optional()->unique()->word(),
            'itemInfo' => $faker->realText(),
            'category' => $category,
            'price' => rand(0, 99999999),
        ]);
        $response->assertStatus(200);

        $this->assertEquals(1, Item::count());
    }
}
