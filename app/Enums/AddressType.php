<?php

namespace App\Enums;

/**
 * @method static AddressType Shipping()
 */
enum AddressType: string
{
    case Shipping = 'shipping';
    case Billing = 'billing';
}
