<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Case06SearchTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_name()
    {
        $faker = Factory::create('ja_JP');
        User::factory()->count(rand(1, 10))->create();
        Item::factory()->count(rand(1, 100))->create();
        $itemNames = Item::pluck('name');
        $searchWord = $faker->randomLetter();
        $matchName = [];
        $noMatchName = [];
        foreach ($itemNames as $itemName) {
            if (Str::contains($itemName, $searchWord)) {
                array_push($matchName, 'class="item-name">' . $itemName . '</label>');
            } else {
                array_push($noMatchName, 'class="item-name">' . $itemName . '</label>');
            }
        }
        $response = $this->get('/?keyword=' . $searchWord);
        $response->assertSee($matchName, false);
        $response->assertDontSee($noMatchName, false);
    }
    public function test_keep()
    {
        $faker = Factory::create('ja_JP');
        $other = User::factory()->create();
        $items = Item::factory()->count(rand(1, 100))->create();
        $user = User::factory()->create();
        foreach ($items as $item) {
            DB::table('favorites')->insert(
                [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                ]
            );
        }
        // $items = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc');
        $itemNames = Item::pluck('name');
        $searchWord = $faker->randomLetter();
        $matchName = [];
        $noMatchName = [];
        foreach ($itemNames as $itemName) {
            if (Str::contains($itemName, $searchWord)) {
                array_push($matchName, $itemName . '</label>');
            } else {
                array_push($noMatchName, $itemName . '</label>');
            }
        }
        $response = $this->actingAs($user)->get('/?keyword=' . $searchWord);
        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=' . $searchWord);
        $response->assertSee('value="' . $searchWord . '"', false);
        $response->assertSee($matchName, false);
        $response->assertDontSee($noMatchName, false);
    }
}
