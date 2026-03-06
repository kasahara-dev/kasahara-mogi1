<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Message;
use App\Models\Review;
use Faker\Factory;
use Database\Seeders\ProfilesTableSeeder;
use Database\Seeders\AddressesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ItemsTableSeeder;
use Database\Seeders\MessagesTableSeeder;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompletedMail;
use Carbon\Carbon;
class CaseProTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
        protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            UsersTableSeeder::class,
            AddressesTableSeeder::class,
            ProfilesTableSeeder::class,
            ItemsTableSeeder::class
            ]);
        $this->user = User::first();
        $this->faker = Factory::create('ja_JP');
    }
    public function test_取引チャット(){
        $buyPurchase = Purchase::create([
            'item_id' => rand(6,10),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $sellPurchase = Purchase::create([
            'item_id' => rand(1,5),
            'user_id' => rand(2,3),
            'user_name' => $this->faker->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $this->seed(MessagesTableSeeder::class);
        $message = Message::inRandomOrder()
            ->where('user_id','<>',$this->user->id)
            ->first();
        $this->actingAs($this->user)
            ->get('/mypage?page=in-progress')
            ->assertOk()
            ->assertViewIs('profile.mypage');
    }
    public function test_評価確認(){
        $max_rate = count(config('rate'));
        $buyPurchase = Purchase::create([
            'item_id' => rand(6,10),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $buy_user = rand(2,3);
        $sellPurchase = Purchase::create([
            'item_id' => rand(1,5),
            'user_id' => $buy_user,
            'user_name' => $this->faker->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $otherPurchase = Purchase::create([
            'item_id' => rand(6, 10),
            'user_id' => 3,
            'user_name' => $this->faker->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $buyRate = rand(1,$max_rate);
        $sellRate = rand(1,$max_rate);
        $otherRate = rand(1,$max_rate);
        Review::create([
            'user_id' => 2,
            'purchase_id' => $buyPurchase->id,
            'rate' => $buyRate,
        ]);
        Review::create([
            'user_id' => $buy_user,
            'purchase_id' => $sellPurchase->id,
            'rate' => $sellRate,
        ]);
        Review::create([
            'user_id' => 3,
            'purchase_id' => $otherPurchase->id,
            'rate' => $otherRate,
        ]);
        $rate_avg = round(($buyRate + $sellRate) / 2);
        for ($i = 1; $i <= $max_rate; $i++){
            if($i<=$rate_avg){
                $starIcon[] = 'user-rate--icon__active';
            }else{
                $starIcon[] = 'user-rate--icon__inactive';
            }
        }
        $this->actingAs($this->user)
            ->get('/mypage')
            ->assertOk()
            ->assertViewIs('profile.mypage')
            ->assertSeeInOrder($starIcon);
    }
    public function test_チャット投稿(){
        $rand = rand(0, 10);
        if($rand < 5){
            $purchase = Purchase::create([
                'item_id' => rand(6,10),
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
                'payment' => rand(1, 2),
                'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
                'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
                'building' => $this->faker->secondaryAddress,
            ]);
        }else{
            $buy_user = rand(2,3);
            $purchase = Purchase::create([
                'item_id' => rand(1,5),
                'user_id' => $buy_user,
                'user_name' => $this->faker->name,
                'payment' => rand(1, 2),
                'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
                'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
                'building' => $this->faker->secondaryAddress,
            ]);
        }
        $this->actingAs($this->user)
            ->get('/message/' . $purchase->id)
            ->assertOk()
            ->assertViewIs('message.message')
            ->assertViewHas('purchase',$purchase);
    }
    public function test_チャット編集削除(){
        $purchase = Purchase::create([
            'item_id' => rand(6,10),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $message = Message::create([
            'purchase_id' => $purchase->id,
            'user_id' => $this->user->id,
            'detail' => $this->faker->sentence,
        ]);
        $newText = $this->faker->sentence;
        $this->actingAs($this->user)
            ->put('/message/' . $purchase->id,[
                'message_id' => $message->id,
                'message' => [$message->id => $newText]
                ]);
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'user_id' => $this->user->id,
            'detail' => $newText,
        ]);
        $this->actingAs($this->user)
            ->delete('/message/' . $purchase->id,[
                'message_id' => $message->id,
                ]);
        $this->assertDatabaseMissing('messages',['id' => $message->id]);
    }
    public function test_評価(){
        Mail::fake();
        $purchase = Purchase::create([
            'item_id' => rand(6,10),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
        ]);
        $this->actingAs($this->user)
            ->patch('/message/' . $purchase->id);
        $this->assertDatabaseHas('purchases',['id'=>$purchase->id,'status'=>1]);
    }
    public function test_メール通知(){
        Mail::fake();
        $sendEmail=User::find(2)->email;
        $purchase = Purchase::create([
            'item_id' => rand(6,10),
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'payment' => rand(1, 2),
            'post_number' => substr_replace($this->faker->postcode, '-', 3, 0),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->secondaryAddress,
            'status' => 1,
        ]);
        $this->actingAs($this->user)
            ->patch('/message/' . $purchase->id);
        Mail::assertSent(TransactionCompletedMail::class,function ($mail) use ($sendEmail) {
            return $mail->hasTo($sendEmail);
        });
    }
}
