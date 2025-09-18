<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
class TopPageTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_all_items()
    {
        $this->seed();
        $itemIds = Item::pluck('id');
        $response = $this->get('/');
        foreach ($itemIds as $id) {
            $response->assertSee(Item::find($id)->name);
        }
    }
}
