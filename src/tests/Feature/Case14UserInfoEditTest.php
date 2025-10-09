<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use App\Models\Profile;
use App\Models\Address;

class Case14UserInfoEditTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_edit()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);
        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee($user->img_path, false);
        $response->assertSee('value="' . $user->name . '"', false);
        $response->assertSee('value="' . $address->post_number . '"', false);
        $response->assertSee('value="' . $address->address . '"', false);
        $response->assertSee('value="' . $address->building . '"', false);
    }
}
