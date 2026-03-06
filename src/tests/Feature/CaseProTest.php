<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\Profile;
use Faker\Factory;

class CaseProTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_取引チャット(){
        $faker = Factory::create('ja_JP');
        $other = User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        $user_address = Address::factory()->create();
        $other_address = Address::factory()->create();
        $user_profile = Profile::create([
            'user_id' => $user->id,
            'address_id' => $user_address->id,
        ]);
        $other_profile = Profile::create([
            'user_id' => $other->id,
            'address_id' => $other_address->id,
        ]);
        Purchase::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($faker->postcode, '-', 3, 0),
            'address' => $faker->prefecture . $faker->city . $faker->streetAddress,
            'building' => $faker->secondaryAddress,
        ]);
    }
    public function test_評価確認(){
        // 
    }
    public function test_チャット投稿(){
        // 
    }
    public function test_チャット編集削除(){
        // 
    }
    public function test_評価(){
        // 
    }
    public function test_メール通知(){
        // 
    }
}
