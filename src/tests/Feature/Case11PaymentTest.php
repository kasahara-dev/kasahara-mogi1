<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Faker\Factory;

class Case11PaymentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_subtotal()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
    }
}
