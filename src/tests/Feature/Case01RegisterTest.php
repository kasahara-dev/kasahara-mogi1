<?php

namespace Tests\Feature;

use Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use Faker\Factory;

class Case01RegisterTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_name_required()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/register', [
            'name' => '',
            'email' => $faker->safeEmail(),
            'password' => $faker->password(8),
        ]);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'name' => 'お名前を入力してください',
        ]);
    }
    public function test_validation_email_required()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/register', [
            'name' => $faker->name(),
            'email' => '',
            'password' => $faker->password(8),
        ]);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test_validation_password_required()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/register', [
            'name' => $faker->name(),
            'email' => $faker->safeEmail(),
            'password' => '',
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test_validation_password_min()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/register', [
            'name' => $faker->name(),
            'email' => $faker->safeEmail(),
            'password' => $faker->password(7, 7),
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }
    public function test_validation_password_diff()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/register', [
            'name' => $faker->name(),
            'email' => $faker->safeEmail(),
            'password' => $faker->unique->password(8),
            'password_confirmation' => $faker->unique->password(8),
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'password' => 'パスワードと一致しません',
        ]);
    }
    public function test_register()
    {
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
        $user = User::first();
        $this->assertTrue(Hash::check($password, $user->password));
        $response->assertRedirect('/mypage/profile');
    }
}
