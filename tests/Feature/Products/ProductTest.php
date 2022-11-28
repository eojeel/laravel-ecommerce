<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    function test_a_user_can_see_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200)
        ->json('data');
    }

    function test_a_user_can_view_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/procucts/');
    }
}
