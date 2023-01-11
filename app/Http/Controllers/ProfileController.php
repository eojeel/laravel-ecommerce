<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        return Inertia::render('Profile/profile', [
            'user' => $request->user(),
            'addresses' => $request->user()->customer->shippingAddresses(),
        ]);
    }
}
