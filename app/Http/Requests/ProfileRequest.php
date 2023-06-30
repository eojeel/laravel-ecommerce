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
            'email' => ['required', 'string', 'email', 'max:255'],
            //unique:users'
            'shipping_address1' => ['required'],
            'shipping_address2' => ['required'],
            'shipping_city' => ['required'],
            'shipping_county' => ['required'],
            'shipping_postcode' => ['required'],
            'shipping_country_code' => ['required', 'exists:countries,code'],

            'billing_address1' => ['required'],
            'billing_address2' => ['required'],
            'billing_city' => ['required'],
            'billing_county' => ['required'],
            'billing_postcode' => ['required'],
            'billing_country_code' => ['required', 'exists:countries,code'],
        ];
    }

    public function attributes()
    {
        return [
            'billing_address1' => 'billing_address1 1',
            'billing_address2' => 'billing_address1 2',
            'billing_city' => 'city',
            'billing_county' => 'county',
            'billing_postcode' => 'postcode',
            'billing_country_code' => 'country',

            'shipping_address1' => 'shipping_address1 1',
            'shipping_address2' => 'shipping_address1 2',
            'shipping_city' => 'city',
            'shipping_county' => 'county',
            'shipping_postcode' => 'postcode',
            'shipping_country_code' => ['required', 'exists:countries,code'],
        ];
    }
}
