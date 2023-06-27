<?php

namespace Tests\Feature;

use App\Models\Product;
use Inertia\Testing\AssertableInertia as Assert;

test('displays a list of products', function () {

    $products = Product::factory(8)->create();

    $this->get(route('index'))
    ->assertInertia(fn (Assert $page) =>
        $page->component('Products/Index')
        ->where('products.data', function($products) {
            return count($products) === 8;
        })
        ->where('products.current_page', 1)
    );
});
