<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Faker\Factory;


class Case12SendAddressTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_address()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $payment = rand(1, 2);
        $address = $faker->address;
        $building = $faker->secondaryAddress;
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);

        $response = $this->actingAs($user)->followingRedirects()->post('/purchase/address/' . $item->id, ['payment' => $payment, 'post_number' => $postNumber, 'building' => $building, 'address' => $address]);
        $response->assertOk();
        $response->assertSee($postNumber);
        $response->assertSee($address);
        $response->assertSee($building);
    }
    public function test_change_send_address()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);

        $payment = rand(1, 2);
        $data = [
            'item_id' => $item->id,
            'payment' => $payment,
            'address' => $faker->address,
        ];

        $address = $faker->address;
        $building = $faker->secondaryAddress;
        $postNumber = substr_replace($faker->postcode, '-', 3, 0);

        $this->actingAs($user)->withSession([
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ])->post('/purchase/address/' . $item->id, [
                    'payment' => $payment,
                    'post_number' => $postNumber,
                    'building' => $building,
                    'address' => $address
                ]);
        $request = $this->actingAs($user)->post('/purchase/' . $item->id, $data);
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'payment' => $payment,
            'address' => $address,
            'post_number' => $postNumber,
            'building' => $building,
        ]);
    }
}
