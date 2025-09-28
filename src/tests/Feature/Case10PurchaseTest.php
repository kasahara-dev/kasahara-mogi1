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
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);
        $this->assertEquals(Purchase::count(), 0);
        $data = [
            'item_id' => $item->id,
            'payment' => rand(1, 2),
        ];
        $this->withSession([
            'address' => $faker->address,
            'post_number' => $postNumber,
            'building' => $faker->secondaryAddress,
        ])->actingAs($user)->post('/purchase/' . $item->id, $data);
        $this->assertEquals(Purchase::count(), 1);
    }
    public function test_sold()
    {
    }
    public function test_mypage()
    {
    }
}
