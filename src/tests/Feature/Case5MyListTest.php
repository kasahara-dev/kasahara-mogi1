<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;


class Case5MyListTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_favorite()
    {
        User::factory()->count(rand(2, 10))->create();
        $userId=User::pluck('id')->random();
        Item::factory()->count(rand(1, 100))->create();
        $response = $this->get('/?tab=mylist');

        $item = Item::pluck('user_id')->random();
        $user = User::where('');
        DB::table('favorites')->insert(
            [
                'user_id' => '1',
                'item_id' => '4',
            ]
        );
    }
}
