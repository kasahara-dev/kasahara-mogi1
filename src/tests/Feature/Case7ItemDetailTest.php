<?php

namespace Tests\Feature;

use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategoriesTableSeeder;
class Case7ItemDetailTest extends TestCase
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
        $users = User::factory()->count(rand(1, 10))->create();
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
        $response = $this->get(route('detail', ['item_id' => '1']));
        $response->assertSee($item->img_path, false);
        // $response->assertSee($item->name);
        // $response->assertSee($item->brand);
        // $response->assertSee($item->price);
        // $response->assertSee(DB::table('favorites')->count());
        // $response->assertSee(Comment::count());
        // $response->assertSee($item->detail);
        // $response->assertSee($category->name);
        // $response->assertSee(config('condition')[$item->condition]);
    }
}
