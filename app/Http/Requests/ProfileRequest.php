<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:7'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'shipping.address1' => ['required'],
            'shipping.address2' => ['required'],
            'shipping.city' => ['required'],
            'shipping.county' => ['required'],
            'shipping.postcode' => ['required'],
            'shipping.country_code' => ['required', 'exists:countries,code'],

            'billing.address2' => ['required'],
            'billing.address1' => ['required'],
            'billing.city' => ['required'],
            'billing.county' => ['required'],
            'billing.postcode' => ['required'],
            'billing.country_code' => ['required', 'exists:countries,code'],
        ];
    }

     public function ()
    {
        return [
            'billing.address1' => 'address 1',
            'billing.address2' => 'address 2',
            'billing.city' => 'city',
            'billing.county' => 'county',
            'billing.postcode' => 'postcode',
            'billing.country_code' => 'country',

            'shipping.address1' => 'address 1',
            'shipping.address2' => 'address 2',
            'shipping.city' => 'city',
            'shipping.county' => 'county',
            'shipping.postcode' => 'postcode',
            'shipping.country_code' => 'country',
        ];
    }
}
