<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\CartItem;
use Stripe\StripeClient;
use App\Http\Helpers\Cart;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($products, $cartItems) = $this->getProductsCartItems();
        $total = 0;
        foreach ($products as &$product) {
            $total += $product->price + $cartItems[$product->id]['quantity'];
            $product['removeUrl'] = route('cart.remove', $product);
            $product['updateQuanityUrl'] = route('cart.update-quanity', $product);
        }

        return Inertia::render('Cart/Cart', ['cartitems' => $cartItems, 'products' => $products, 'total' => $total, 'cartItemsCount' => Cart::getCartItemsCount()]);
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
        if ($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            } else {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ];
                cartItem::create($data);
            }

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            $productFound = false;
            foreach ($cartItems as &$item) {
                if ($item['product_id'] == $product->id) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }
        }

        if (! $productFound) {
            $cartItems[] = [
                'user_id' => null,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

        return response(['count' => Cart::getCountFromItems($cartItems)]);
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
        $quantity = (int) $request->post('quantity');
        $user = $request->user();
        if ($user) {
            cartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            foreach ($cartItems as &$item) {
                if ($item['product_id'] == $product->id) {
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
        if ($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItem) {
                $cartItem->Delete();
            }

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            foreach ($cartItems as $key => $item) {
                if ($item['product_id'] == $product->id) {
                    array_splice($cartItems, $key, 1);
                    //unset($cartItems[$key]);
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function checkout(Request $request)
    {
        $stripe = new StripeClient(getenv('STRIPE_SECRET_KEY'));

        list($products, $cartItems) = $this->getProductsCartItems();

        $line_items = [];
        foreach($products as $product)
        {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => $line_items,
            'success_url' => route('cart.checkout-success'),
            'cancel_url' => route('cart.checkout-cancel'),
        ]);

        return $session->url;
    }

    private function getProductsCartItems(): array
    {
        $cartItems = Cart::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Arr::keyBy(Product::query()->whereIn('id', $ids)->get(), 'id');
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        return [$products, $cartItems];
    }
}
