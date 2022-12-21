<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Http\Helpers\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function view(Product $product)
    {
        return Inertia::render('Products/View',  [
            'product' => $product,
            'cartItemsCount' => Cart::getCartItemsCount(),
        ]);
    }
}
