<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use App\Models\Customer;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        /** @var /App/Model/User $user */
        $user = request()->user();
        /** @var /App/Models/Customer $customer */
        $customer = $user->customer;
        $shippingAddress = $customer->shippingAddress ?: new CustomerAddress(['type' => AddressType::Shipping]);
        $billingAddress = $customer->billingAddress ?: new CustomerAddress(['type' => AddressType::Billing]);
        $countries = Country::query()->orderBy('name')->get();

        return Inertia::render('Profile/profile', [
            'user' => $user,
            'customer' => $customer,
            'shippingaddress' => $shippingAddress,
            'billingaddress' => $billingAddress,
            'countries' => $countries
        ]);
    }
}
