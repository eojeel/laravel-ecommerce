<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'last_name',
        'phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    private function _getAddresses(): hasOne
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'user_id');
    }

    public function shippingAddress(): hasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::Shipping->value);
    }

    public function billingAddress(): hasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::Billing->value);
    }
}
