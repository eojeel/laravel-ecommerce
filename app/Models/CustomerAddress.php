<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'address1', 'address2', 'city', 'county', 'postcode', 'country_code', 'customer_id'];

    public function customer(): belongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function country(): belongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
