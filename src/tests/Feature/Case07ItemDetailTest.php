<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategoriesTableSeeder;

class Case07ItemDetailTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_info()
    {
        $this->seed(CategoriesTableSeeder::class);
        $usersCount = rand(1, 10);
        $users = User::factory()->count($usersCount)->create();
        foreach ($users as $user) {
            Profile::create([
                'user_id' => $user->id,
            ]);
        }
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        foreach ($users as $user) {
            $do = rand(0, 10);
            if ($do > 5) {
                DB::table('favorites')->insert(
                    [
                        'user_id' => $user->id,
                        'item_id' => $item->id,
                    ]
                );
            }
        }
        Comment::factory()->count(rand(1, 10))->create();
        $response = $this->get('/item/' . $item->id);
        $response->assertOk();
        $response->assertSee($item->img_path, false);
        $response->assertSee('"item-name">' . $item->name . '</h2>', false);
        $response->assertSee('"brand-name">' . $item->brand . '</div>', false);
        $response->assertSee(number_format($item->price));
        $response->assertSee('<label class="icon-count">' . DB::table('favorites')->count() . '</label>', false);
        $response->assertSee('<div class="icon-count">' . Comment::count() . '</div>', false);
        $response->assertSee('"info-detail">' . $item->detail . '</dd>', false);
        $response->assertSee($category->name);
        $response->assertSee(config('condition')[$item->condition]);
    }
    public function test_categories()
    {
        $this->seed(CategoriesTableSeeder::class);
        $categories = Category::all();
        User::factory()->create();
        $item = Item::factory()->create();
        $insert = [];
        foreach ($categories as $category) {
            array_push($insert, ['category_id' => $category->id, 'item_id' => $item->id]);
        }
        DB::table('category_item')->insert($insert);
        $response = $this->get('/item/' . $item->id);
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
