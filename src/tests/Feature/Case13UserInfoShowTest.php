<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class Case13UserInfoShowTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        User::factory()->count(rand(1, 10))->create();
        $user = User::factory()->create();
        Item::factory()->count(20)->create();
        Purchase::factory()->count(10)->create();
        $address = Address::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);
        $sellItemIds = Item::where('user_id', $user->id)->pluck('id')->toArray();
        $buyItemIds = Purchase::where('user_id', $user->id)->pluck('item_id');
        $response = $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee($profile->img_path);
        $response->assertSee($user->name);
        foreach ($sellItemIds as $sellItemId) {
            $response->assertSee('<a href="/item/' . $sellItemId . '"', false);
        }
        foreach ($buyItemIds as $buyItemId) {
            $response->assertDontSee('<a href="/item/' . $buyItemId . '"', false);
        }
        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSee($profile->img_path);
        $response->assertSee($user->name);
        foreach ($sellItemIds as $sellItemId) {
            $response->assertDontSee('<a href="/item/' . $sellItemId . '"', false);
        }
        foreach ($buyItemIds as $buyItemId) {
            $response->assertSee('<a href="/item/' . $buyItemId . '"', false);
        }

    }
}
