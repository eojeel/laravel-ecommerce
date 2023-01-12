<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Helpers\Cart;
use App\Models\Api\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Index',  [
            'products' => Product::paginate(8),
            'cartItemsCount' => Cart::getCartItemsCount(),
        ]);
    }
}
