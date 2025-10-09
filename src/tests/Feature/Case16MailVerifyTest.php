<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
        $faker = Factory::create('ja_JP');
        $email = $faker->safeEmail();
        $password = $faker->unique->password;
        $user = User::create([
            'name' => $faker->name(),
            'email' => $email,
            'password' => bcrypt($password),
        ]);
    }
}
