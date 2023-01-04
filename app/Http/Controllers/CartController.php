<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Http\Helpers\Cart;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = Cart::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::query()->whereIn('id', $ids)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        $total = 0;
        foreach ($products as $product)
        {
            $total += $product->price + $cartItems[$product->id]['quantity'];
        }

        return Inertia::render('Cart/Cart', ['cartitems' => $cartItems, 'products' => $products, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
        if ($user)
        {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if ($cartItem)
            {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            }
            else
            {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity
                ];
                cartItem::create($data);
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        }
        else
        {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            $productFound = false;
            foreach ($cartItems as &$item)
            {
                if ($item['product_id'] == $product->id)
                {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }
        }

        if (!$productFound)
        {
            $cartItems[] = [
                'user_id' => null,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ];
        }
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

        return response(['count' => Cart::getCountFromItems($cartItems)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $quantity = (int)$request->post('quantity');
        $user = $request->user();
        if($user)
        {
            cartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            foreach ($cartItems as &$item)
            {
                if ($item['product_id'] == $product->id)
                {
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Response $response, Product $product)
    {
        $user = $request->user();
        if($user)
        {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if($cartItem)
            {
                $cartItem->Delete();
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            foreach ($cartItems as $key => $item)
            {
                if ($item['product_id'] == $product->id)
                {
                    array_splice($cartItems, $key, 1);
                    //unset($cartItems[$key]);
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
