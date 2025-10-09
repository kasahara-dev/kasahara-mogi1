<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Faker\Factory;


class Case05MyListTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_favorite()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $items = Item::factory()->count(rand(1, 100))->create();
        DB::table('items')->update(['user_id' => $other->id]);
        $itemId = Item::pluck('id')->random();
        DB::table('favorites')->insert(
            [
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]
        );
        $favItemName = Item::find($itemId)->name;
        $notFavItemName = Item::where('id', '<>', $itemId)->pluck('name');
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee($favItemName);
        $response->assertDontSee($notFavItemName);
    }
    public function test_sold()
    {
        $faker = Factory::create('ja_JP');
        $user = User::factory()->create();
        $other = User::factory()->create();
        $items = Item::factory()->count(rand(1, 100))->create();
        DB::table('items')->update(['user_id' => $other->id]);
        $itemId = Item::pluck('id')->random();
        DB::table('favorites')->insert(
            [
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]
        );
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertDontSee('Sold</p>', false);
        Purchase::create([
            'item_id' => $itemId,
            'user_id' => $user->id,
            'user_name' => $faker->name(),
            'payment' => rand(1, 2),
            'post_number' => substr_replace($faker->postcode, '-', 3, 0),
            'address' => $faker->prefecture . $faker->city . $faker->streetAddress,
            'building' => $faker->secondaryAddress,
        ]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('Sold</p>', false);
    }
    public function test_guest()
    {
        User::factory()->create();
        Item::factory()->create();
        $itemNames = Item::pluck('id')->toArray();
        $response = $this->get('/?tab=mylist');
        foreach ($itemNames as $itemName) {
            $response->assertDontSee('<a href="/item/' . $itemName . '"', false);
        }
    }
}
