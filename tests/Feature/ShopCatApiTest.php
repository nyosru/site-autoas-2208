<?php

namespace Tests\Feature;

use App\Models\Catalog;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group api1
 */
class ShopCatApiTest extends TestCase
{
    // use DatabaseMigrations;
    // use RefreshDatabase;

    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function test_example()
    // {
    //     // Catalog::factory(10)->create();
    //     $response = $this->get('/');
    //     $response->assertStatus(200);
    // }


    public function test_catalog_api_enable()
    {
        // $response = $this->get(route('goodscat.show'));
        $response = $this->getJson(route('catalog.index'));
        $response->assertStatus(200);
    }


    public function test_catalog_api_get_info_1cat()
    {
        // $response = $this->get(route('goodscat.show'));
        $response = $this->getJson(route('goodscat.show', ['goodscat' => 'ЦБ002233']));
        $response->assertStatus(200);
    }

    
    /**
     * @group api1
     */
    public function test_catalog_api_one_enable()
    {
        // Catalog::factory(10)->create();
        $cat = Catalog::limit(1)->get();
        $response = $this->getJson(route('catalog.show', $cat[0]->id));
        $response->assertStatus(200);
    }

}