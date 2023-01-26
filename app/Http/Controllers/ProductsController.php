<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use App\Models\Api\Product;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Index', [
            'products' => Product::paginate(8),
            'cartItemsCount' => Cart::getCartItemsCount(),
        ]);
    }
}
