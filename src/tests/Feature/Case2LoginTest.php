<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Faker\Factory;
use Illuminate\Support\Facades\DB;


class Case2LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_email_required()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/login', [
            'email' => '',
            'password' => $faker->password(8),
        ]);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
        $this->get('/login')->assertSeeInOrder([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test_validation_password_required()
    {
        $faker = Factory::create('ja_JP');
        $response = $this->post('/login', [
            'email' => $faker->safeEmail(),
            'password' => '',
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
        $this->get('/login')->assertSeeInOrder([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test_validation_password_diff()
    {
        $faker = Factory::create('ja_JP');
        $email = $faker->safeEmail();
        $password = $faker->unique->password;
        $user = User::factory()->create([
            'name' => $faker->name(),
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
        ]);
        // $param = [
        //     'user_id' => $user->id,
        //     'address_id' => null,
        // ];
        // DB::table('profiles')->insert($param);
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $faker->unique->password,
        ]);
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }
    public function test_login()
    {
        $faker = Factory::create('ja_JP');
        $email = $faker->safeEmail();
        $password = $faker->unique->password;
        $user = User::factory()->create([
            'name' => $faker->name(),
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
        ]);
        // $param = [
        //     'user_id' => $user->id,
        //     'address_id' => null,
        // ];
        // DB::table('profiles')->insert($param);
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect('/?page=mylist');
    }
}
