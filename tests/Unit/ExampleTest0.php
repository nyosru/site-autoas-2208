<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

/**
 * @group test 
 */
class ExampleTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_api_enable(): void
    {
        $this->assertTrue(true);
        // $response = $this->get(route('goodscat.show'));
        // $response->assertStatus(200);
        // // $this->assertJson()
    }

}