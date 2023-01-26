<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_see_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200)
        ->json('data');
    }

    public function test_a_user_can_view_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->get('/api/procucts/');
    }
}
