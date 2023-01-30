<?php

namespace App\Enums;

/**
 * @method static OrderStatus()
 */
enum OrderStatus: string
{
    case unpaid = 'unpaid';
    case paid = 'paid';
}
