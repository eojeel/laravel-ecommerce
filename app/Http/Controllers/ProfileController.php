<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use InvalidArgumentException;

class ProfileController extends Controller
{
    /**
     * @return Response
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
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
            'countries' => $countries,
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function update(ProfileRequest $request)
    {
        $customerData = $request->validated();
        foreach ($customerData as $k => $v) {
            if (Str::startsWith($k, 'shipping_')) {
                $shippingData[str_replace('shipping_', '', $k)] = $v;
            }
            if (Str::startsWith($k, 'billing')) {
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = request()->user();

        $passwordData = $request->validated();

        $user->password = Hash::make($passwordData['new_password']);
        $user->save();

        return redirect()->route('profile.view')->with('message', 'Your password was successfully updated.');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function destroy(Request $request)
    {

        $user = request()->user();

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password does not match our records.'],
            ]);
        }

        $user->delete();

        return redirect()->route('index')->with('message', 'Your account was successfully deleted.');
    }
}
