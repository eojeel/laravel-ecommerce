<?php

namespace App\Http\Helpers;

use App\Models\CartItem;

class Cart
{
    public static function getCartItemsCount(): int
    {
        $request = Request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->count();
        }

        return array_reduce(
            self::getCookieCartItems(),
            fn ($carry, $item) => $carry + $item['quantity'],
            0
        );
    }

    public static function getCartItems()
    {
        $request = Request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->get()->map(
                fn ($item) => [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ]
            );
        }

        return self::getCookieCartItems();
    }

    public static function getCookieCartItems(): array
    {
        $request = Request();

        return json_decode($request->cookie('cart_items'), true) ?? [];
    }

    public static function getCountFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            fn ($carry, $item) => $carry + $item['quantity'],
            0
        );
    }

    public static function moveCartItemsIntoDb()
    {
        $request = Request();
        $cartItems = self::getCookieCartItems();
        $dbCartItems = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_id');

        foreach ($cartItems as $cartItem) {
            if (! isset($dbCartItems[$cartItem['product_id']])) {
                $newCartItems[] = [
                    'user_id' => $request->user()->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            }
        }

        if (! empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }
    }
}
