<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

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
        Notification::fake();
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
        $user = User::first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }
    public function test_verify()
    {
        $faker = Factory::create('ja_JP');
        $email = $faker->safeEmail();
        $password = $faker->unique->password;
        $user = User::create([
            'name' => $faker->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $this->actingAs($user)->get(env('APP_URL') . ':8025')->assertOk();
    }
    public function test_redirect()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->get($verificationUrl);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/mypage/profile');
    }
}
