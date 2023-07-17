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

function createFakeUserData(): array
{
    return [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'phone' => fake()->phoneNumber(),
        'email' => fake()->email(),
        'shipping_address1' => fake()->streetAddress(),
        'shipping_address2' => fake()->secondaryAddress(),
        'shipping_city' => fake()->city(),
        'shipping_state' => fake()->state(),
        'shipping_postcode' => fake()->postcode(),
        'shipping_county' => fake()->country(),
        'billing_country_code' => 'usa',

        'billing_address1' => fake()->streetAddress(),
        'billing_address2' => fake()->secondaryAddress(),
        'billing_city' => fake()->city(),
        'billing_state' => fake()->state(),
        'billing_postcode' => fake()->postcode(),
        'billing_county' => fake()->country(),
        'shipping_country_code' => 'usa',
    ];
}
