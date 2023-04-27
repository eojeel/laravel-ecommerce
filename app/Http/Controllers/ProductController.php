<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function view(Product $product)
    {
        return Inertia::render('Products/View', [
            'product' => $product,
        ]);
    }
}
