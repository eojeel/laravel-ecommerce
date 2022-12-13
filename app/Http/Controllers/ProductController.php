<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Index',  [
            'products' => Product::paginate(5),
            'loggedIn' => Auth::check(),
        ]);
    }
}
