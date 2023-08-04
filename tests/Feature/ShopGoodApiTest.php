<?php

namespace Tests\Feature;

use App\Models\Catalog;
use App\Models\Good;
use App\Models\GoodAnalog;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

/**
 * @group good
 */
class ShopGoodApiTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

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

    // public function test_example_api()
    // {
    //     // $response = $this->get(route('goodscat.show'));
    //     $response = $this->getJson(route('good.show', ['goodscat' => 'ЦБ002233']));
    //     $response->assertStatus(200);
    // }

    // public function test_catalog_api_enable()
    // {
    //     // $response = $this->get(route('goodscat.show'));
    //     $response = $this->getJson(route('catalog.index'));
    //     $response->assertStatus(200);
    // }

    /**
     * @group api1
     */
    public function test_good_api_one_enable()
    {

        // $cats = 
        Catalog::factory(10)->create();
        // dd($cats);
        $cat = Catalog::limit(1)->get();

        $goods =
            Good::factory(10)->create(['a_categoryid' => $cat[0]->a_id]);
        // dd($goods[0]);

        $response = $this->getJson(route('good.show', $goods[0]->a_id));
        $response->assertStatus(200);

    }

    public function test_good_api_analogi_havent()
    {

        $cats = Catalog::factory(2)->create();
        // dd($cats);

        $goods =
            Good::factory(10)->create(
                ['a_categoryid' => $cats[0]->a_id]
            );

        // // dd($goods[0]);
        // $goods = Good::limit(1)->get();
        // dd($goods[0]);
        $ga = GoodAnalog::factory(5)->create(
            [
                'art_origin' => $goods[0]->a_id
            ]
        );
        // dd($ga);
        $response = $this->getJson(route('good.show', $goods[0]->a_id));
        // dd($response);
        $response->assertStatus(200)
            ->assertSeeText($ga[0]->head);

    }

}