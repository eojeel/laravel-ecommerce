<?php

namespace App\Enums;

/**
 * @method static OrderStatus()
 */
enum PaymentStatus: string
{
    case unpaid = 'unpaid';
    case pending = 'pending';
    case paid = 'paid';
}
