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
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
        // $user = User::first();
        Mail::assertSent(Verification::class);
        // Mail::assertSent(Verification::class, function ($mail) {
        //     return $mail->hasTo($email);
        // });
        // Mail::assertSent(Verification::class, 1);
    }
    public function test_verify()
    {
        User::factory()->create();
    }
    public function test_redirect()
    {
    }
}
