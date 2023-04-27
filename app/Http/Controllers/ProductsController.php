<?php

namespace App\Http\Controllers;

use App\Models\Api\Product;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::paginate(8),
        ]);
    }
}
