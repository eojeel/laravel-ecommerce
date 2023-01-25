<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use App\Enums\AddressType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Http\Requests\ProfileRequest;

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

    public function update(ProfileRequest $request)
    {
        $customerData = $request->validated();
        foreach($customerData as $k => $v)
        {
            if(Str::startsWith($k, 'shipping_'))
            {
                $shippingData[str_replace('shipping_', '', $k)] = $v;
            }
            if(Str::startsWith($k, 'billing'))
            {
                $billingData[str_replace('billing_', '', $k)] = $v;
            }
        }

        /** @var /App/Model/User $user */
        $user = request()->user();
        $customer = $user->customer;
        //$customer->update($customerData);

        if ($customer->shippingAddress) {
            $customer->shippingAddress->update($shippingData);
        } else {
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            CustomerAddress::create($shippingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }
        return redirect()->route('profile.view')->with('message', 'Profile was sucessfully updated.');
    }
}
