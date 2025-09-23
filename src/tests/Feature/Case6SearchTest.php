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

class Case6SearchTest extends TestCase
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
        // $items = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc');
        $itemNames = Item::pluck('name');
        $searchWord = $faker->randomLetter();
        $matchName = [];
        $noMatchName = [];
        foreach ($itemNames as $itemName) {
            if (Str::contains($itemName, $searchWord)) {
                if (!in_array($itemName, $matchName, true)) {
                    array_push($matchName, $itemName . '</label>');
                }
            } else {
                if (!in_array($itemName, $noMatchName, true)) {
                    array_push($noMatchName, $itemName . '</label>');
                }
            }
        }
        $response = $this->get('/?keyword=' . $searchWord);
        $response->assertSee($matchName, false);
        $response->assertDontSee($noMatchName, false);
    }
    public function test_keep(){
        $faker = Factory::create('ja_JP');
        $user=User::factory()->create();
        Item::factory()->count(rand(1, 100))->create();

        // $items = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc');
        $itemNames = Item::pluck('name');
        $searchWord = $faker->randomLetter();
        $matchName = [];
        $noMatchName = [];
        foreach ($itemNames as $itemName) {
            if (Str::contains($itemName, $searchWord)) {
                if (!in_array($itemName, $matchName, true)) {
                    array_push($matchName, $itemName . '</label>');
                }
            } else {
                if (!in_array($itemName, $noMatchName, true)) {
                    array_push($noMatchName, $itemName . '</label>');
                }
            }
        }
        $favMatchId = Item::pluck('id')->random();
        DB::table('favorites')->insert(
            [
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]
        );
        $favItemName = Item::find($itemId)->name;

        $response = $this->get('/?keyword=' . $searchWord);
        $response->assertSee($matchName, false);
        $response->assertDontSee($noMatchName, false);

    }
}
