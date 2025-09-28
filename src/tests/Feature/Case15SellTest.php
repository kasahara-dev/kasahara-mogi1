<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
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
        $profile = Profile::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);
        // $conditions = array_keys(config('condition'));
        Storage::fake('public');
        $file = UploadedFile::fake()->image('img.jpeg', 100, 100);
        $fileName = Str::uuid() . '.jpeg';
        $path = Storage::disk('public')->putFileAs('item', $file, $fileName);

        // $file = $request->file('item_img_input');
        // $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        // $path = Storage::disk('public')->putFileAs('item', $file, $fileName);
        $this->assertEquals(0, Item::count());

        $category[] = '1';
        $condition = rand(1, 4);
        $itemName = $faker->unique()->word();
        $brandName = $faker->unique()->optional()->word();
        $itemInfo = $faker->realText();
        $price = rand(0, 99999999);
        $response = $this->followingRedirects()->actingAs($user)->post('/sell', [
            'item_img_input' => $file,
            'condition' => $condition,
            'itemName' => $itemName,
            'brandName' => $brandName,
            'itemInfo' => $itemInfo,
            'category' => $category,
            'price' => $price,
        ]);
        $response->assertOk();

        $this->assertDatabaseHas(Item::class, [
            // 'img_path' => 'storage/' . $path,
            'condition' => $condition,
            'name' => $itemName,
            'brand' => $brandName,
            'detail' => $itemInfo,
            'price' => $price,
        ]);
        $this->assertDatabaseHas('category_item', [
            'category_id' => $category,
            'item_id' => '1',
        ]);
    }
}
