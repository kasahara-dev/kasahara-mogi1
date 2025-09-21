<?php

namespace Tests\Feature;

use App\Models\Purchase;
use Database\Seeders\AddressesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CommentsTableSeeder;
use Database\Seeders\CategoryItemSeeder;
use Database\Seeders\ProfilesTableSeeder;
use Database\Seeders\PurchasesTableSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FavoritesTableSeeder;
use Database\Seeders\ItemsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
class Case4TopPageTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_all_items()
    {
        $this->seed();
        $itemNames = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->pluck('name')->toArray();
        $itemImages = Item::orderBy('updated_at', 'desc')->orderBy('id', 'desc')->pluck('img_path')->toArray();
        $response = $this->get('/');
        $response->assertSeeInOrder($itemNames);
        $response->assertSeeInOrder($itemImages);
    }
    public function test_sold()
    {
        $this->seed(
            [
                UsersTableSeeder::class,
                CategoriesTableSeeder::class,
                ItemsTableSeeder::class,
                CategoryItemSeeder::class,
                AddressesTableSeeder::class,
                ProfilesTableSeeder::class,
            ]
        );
        $soldCount = Purchase::count();
        $response = $this->get('/');
        $response->assertDontSee('Sold');
        $this->seed(PurchasesTableSeeder::class);
        $response = $this->get('/');
        $response->assertSee('Sold');
    }
    public function test_sell_items()
    {
        $this->seed();
        $user = User::find(1);
        $sellItems = Item::where('user_id', 1)->pluck('name');
        $response = $this->actingAs($user)->get('/');
        foreach ($sellItems as $sellItem) {
            $response->assertDontSee($sellItem);
        }
    }
}
