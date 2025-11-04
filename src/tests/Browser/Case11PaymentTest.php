<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Faker\Factory;

class Case11PaymentTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSubtotal()
    {
        $faker = Factory::create('ja_JP');
        $this->seed(CategoriesTableSeeder::class);
        User::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        Profile::create([
            'user_id' => $user->id,
        ]);
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $item = Item::first();
            $value = $browser->loginAs($user)->visit('/purchase/' . $item->id)
                ->select('payment', '1')
                ->script("return document.querySelector('#payment-name').innerHTML;");
            $innerHTML1 = $value[0];
            $value = $browser->loginAs($user)->visit('/purchase/' . $item->id)
                ->select('payment', '2')
                ->script("return document.querySelector('#payment-name').innerHTML;");
            $innerHTML2 = $value[0];
            $this->assertEquals('コンビニ払い', $innerHTML1);
            $this->assertEquals('カード支払い', $innerHTML2);
        });
    }
}
