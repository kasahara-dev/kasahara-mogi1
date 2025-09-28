<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Case08LikeTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item()
    {
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $othersCount = rand(0, 10);
        $others = User::factory()->count($othersCount)->create();
        $favParm = [];
        if ($othersCount > 0) {
            foreach ($others as $other) {
                array_push($favParm, ['item_id' => $item->id, 'user_id' => $other->id]);
            }
            DB::table('favorites')->insert($favParm);
        }
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertOk();
        $response = $this->actingAs($user)->post('/item/' . $item->id, ['favorite' => $item->id]);
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'item_id' => $item->id]);
        $response->assertRedirect('/item/' . $item->id);
        $response = $this->get('/item/' . $item->id);
        $response->assertSee('class="icon-count">' . DB::table('favorites')->count() . '</label>', false);
    }
    public function test_color()
    {
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        \Log::info('user  is ' . $user->get());
        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertSee('star-regular-full.svg', false);
        $response->assertDontSee('star-solid-full.svg', false);
        $response = $this->followingRedirects()->actingAs($user)->post('/item/' . $item->id, ['favorite' => $item->id]);
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'item_id' => $item->id]);
        // $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertOk();
        $response->assertDontSee('star-regular-full.svg', false);
        $response->assertSee('star-solid-full.svg', false);
    }
    public function test_not_like()
    {
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $response = $this->followingRedirects()->actingAs($user)->post('/item/' . $item->id, ['favorite' => $item->id]);
        $response->assertSee('fav-count">1</label>', false);
        $response = $this->followingRedirects()->actingAs($user)->delete('/item/' . $item->id, ['favorite' => $item->id]);
        $response->assertSee('fav-count">0</label>', false);
    }
}
