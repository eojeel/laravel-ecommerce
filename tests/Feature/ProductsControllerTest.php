<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Product;
use Inertia\Testing\AssertableInertia as Assert;

test('displays a list of products', function () {

    $products = Product::factory(8)->create();

    $response = $this->get(route('index'));

    expect($response)
    ->assertInertia(fn (Assert $page) =>
        $page->component('Products/Index')
        ->where('products.data', function($products) {
            return count($products) === 8;
        })
        ->where('products.current_page', 1)
    );
});
