<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Profile;
use Faker\Factory;

class Case10PurchaseTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $payment = rand(1, 2);
        $address = $faker->address;
        $building = $faker->secondaryAddress;
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);
        $data = [
            'item_id' => $item->id,
            'payment' => $payment,
            'address' => $faker->address,
        ];
        $this->actingAs($user)->withSession([
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ])->post('/purchase/' . $item->id, $data);
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'payment' => $payment,
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ]);
    }
    public function test_sold()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $payment = rand(1, 2);
        $address = $faker->address;
        $building = $faker->secondaryAddress;
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);
        $data = [
            'item_id' => $item->id,
            'payment' => $payment,
            'address' => $faker->address,
        ];
        $this->get('/')->assertDontSee('<p class="item-sold-msg">Sold</p>', false);
        $this->actingAs($user)->withSession([
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ])->post('/purchase/' . $item->id, $data);
        $this->get('/')->assertSee('<p class="item-sold-msg">Sold</p>', false);
    }
    public function test_mypage()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $payment = rand(1, 2);
        $address = $faker->address;
        $building = $faker->secondaryAddress;
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);
        $data = [
            'item_id' => $item->id,
            'payment' => $payment,
            'address' => $faker->address,
        ];
        $this->get('/mypage?page=buy')->assertDontSee('<label for="' . $item->id . '" class="item-name">' . $item->name . '</label>', false);
        $this->actingAs($user)->withSession([
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ])->post('/purchase/' . $item->id, $data);
        $this->get('/mypage?page=buy')->assertSee('<label for="' . $item->id . '" class="item-name">' . $item->name . '</label>', false);
    }
}
