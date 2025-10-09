<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Profile;
use Faker\Factory;

class Case09CommentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $_POST = ['send-comment' => true];
        $comment = $faker->realText();
        $response = $this->followingRedirects()->actingAs($user)->post('/item/' . $item->id, ['itemId' => $item->id, 'commentInput' => $comment]);
        $response->assertOk();
        $response->assertSee('<div class="icon-count">1</div>', false);
        $response->assertSee('コメント(1)');
        $response->assertSee($user->name);
        $response->assertSee($comment);
    }
    public function test_guest_cannot_send()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $comment = $faker->realText();
        $response = $this->get('/item/' . $item->id);
        $response->assertSee('disabled>コメントを送信する</button>', false);
    }
    public function test_validation_null()
    {
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $_POST = ['send-comment' => true];
        $response = $this->actingAs($user)->post('/item/' . $item->id, ['itemId' => $item->id, 'commentInput' => '']);
        $response->assertSessionHasErrors([
            'commentInput' => 'コメントを入力してください',
        ]);
        $response = $this->actingAs($user)->get('/item/' . $item->id)->assertSee('コメントを入力してください');
    }
    public function test_validation_max()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $item = Item::factory()->create();
        $category = Category::inRandomOrder()->first();
        DB::table('category_item')->insert(
            [
                'category_id' => $category->id,
                'item_id' => $item->id,
            ]
        );
        $comment = $faker->realText(256);
        $_POST = ['send-comment' => true];
        $response = $this->actingAs($user)->post('/item/' . $item->id, ['itemId' => $item->id, 'commentInput' => $comment]);
        $response->assertSessionHasErrors([
            'commentInput' => 'コメントは255文字以内で入力してください',
        ]);
        $response = $this->actingAs($user)->get('/item/' . $item->id)->assertSee('コメントは255文字以内で入力してください');

    }
}
