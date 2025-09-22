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
        $itemNames = Item::pluck('name');
        $searchWord = $faker->randomLetter();
        $matchName = array();
        $noMatchName = array();
        foreach ($itemNames as $itemName) {
            if (Str::contains($itemName, $searchWord)) {
                array_push($matchName, $itemName);
            } else {
                array_push($noMatchName, $itemName);
            }
        }
    }
}
