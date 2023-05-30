<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $shippingAddress = $this->user->customer->shippingAddress;
        $billingAddress = $this->user->customer->billingAddress;
        $customer = $this->user->customer;

        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'items' => $this->items->map(fn ($item) => [
                'id' => $item->id,
                'unit_price' => $item->unit_price,
                'quantity' => $item->quantity,
                'product' => [
                    'id' => $item->product->id,
                    'title' => $item->product->title,
                    'slug' => $item->product->slug,
                    'image' => $item->product->image,
                    'price' => $item->product->price,
                ],
            ]),
            'customer' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
                'shippingAddress' => [
                    'id' => $shippingAddress->id,
                    'address1' => $shippingAddress->address1,
                    'address2' => $shippingAddress->address2,
                    'city' => $shippingAddress->city,
                    'state' => $shippingAddress->state,
                    'zipcode' => $shippingAddress->zipcode,
                    'country' => $shippingAddress->country->name,
                ],
                'billingAddress' => [
                    'id' => $billingAddress->id,
                    'address1' => $billingAddress->address1,
                    'address2' => $billingAddress->address2,
                    'city' => $billingAddress->city,
                    'state' => $billingAddress->state,
                    'zipcode' => $billingAddress->zipcode,
                    'country' => $billingAddress->name,
                ],
            ],
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
