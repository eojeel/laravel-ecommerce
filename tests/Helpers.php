<?php

use App\Enums\AddressType;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\User;

function createValidUser(): User
{
    $user = User::factory()->create();

    $customer = Customer::factory()->create(
        [
            'user_id' => $user->id,
        ]
    );

    CustomerAddress::factory()->create(
        [
            'customer_id' => $customer->user_id,
            'type' => AddressType::Shipping,
        ]
    );

    CustomerAddress::factory()->create(
        [
            'customer_id' => $customer->user_id,
            'type' => AddressType::Billing,
        ]
    );

    return $user->refresh();
}
