<?php

namespace App\Enums;

/**
 * @method static AddressType Shipping()
 */
enum AddressType: string
{
    const Shipping = 'shipping';
    const Billing = 'billing';
}
