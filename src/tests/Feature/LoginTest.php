<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_validation_null()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
        $this->get('/login')->assertSeeInOrder([
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test_validation_diff()
    {
        $user = User::factory()->create([
            'name' => '名前',
            'email' => 'logintest@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        // $profile = Profile::factory()->create([
        //     ['user_id' => $user->id]
        // ]);
        $response = $this->post('/login', [
            'email' => 'logintest@example.com',
            'password' => 'passwort',
        ]);
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }
    public function test_pass()
    {
        $user = User::factory()->create(['name' => '名前', 'email' => 'logintest@example.com', 'password' => bcrypt('password'), 'email_verified_at' => now()]);
        // $profile = Profile::factory()->create(['user_id'=>$user->id]);
        $response = $this->post('/login', [
            'email' => 'logintest@example.com',
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect('/?page=mylist');
    }
}
