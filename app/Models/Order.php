<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
}
