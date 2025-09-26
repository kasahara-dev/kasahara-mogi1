<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Case09CommentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send()
    {
    }
    public function test_guest_cannot_send()
    {
    }
    public function test_validation_null()
    {
    }
    public function test_validation_max()
    {
    }
}
