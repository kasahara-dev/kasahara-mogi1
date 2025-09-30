<?php

namespace Tests\Feature;

use App\Mail\Verification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Notifications\VerifyEmail;

class Case16MailVerifyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send()
    {
        Mail::fake();
        $faker = Factory::create('ja_JP');
        $name = $faker->name();
        $email = $faker->safeEmail();
        $password = $faker->unique->password(8);
        $response = $this->post('/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        // $this->assertDatabaseHas('users', [
        //     'name' => $name,
        //     'email' => $email,
        // ]);
        // $user = User::first();
        // Mail::assertSent(VerifyEmail::class);
        // Mail::assertSent(Verification::class, function ($mail) {
        //     return $mail->hasTo($email);
        // });
        // $this->assertSent(Verification::class, function ($mail) use ($user) {
        //     return $mail->hasTo($user->email);
        // });
    }
    public function test_verify()
    {
        $faker = Factory::create('ja_JP');
        $email = $faker->safeEmail();
        $password = $faker->unique->password;
        $user = User::factory()->create([
            'name' => $faker->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $this->actingAs($user)->get(env('APP_URL') . ':8025')->assertOk();
    }
    public function test_redirect()
    {
    }
}
