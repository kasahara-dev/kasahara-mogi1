<?php

namespace Tests\Feature;

use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
    public function test_validation_null()
    {
        $response = $this->post('/register', []);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'name' => 'お名前を入力してください',
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test_validation_pass_min()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'abcdefg',
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
        $this->get('/register')->assertSeeInOrder([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }
    public function test_validation_pass_diff()
    {
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'abcdefgh',
            'password_confirmation' => 'abcdefgi',
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
        $response = $this->post('/register', [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'abcdefgh',
            'password_confirmation' => 'abcdefgh',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'テスト',
            'email' => 'test@example.com',
        ]);
    }
}
