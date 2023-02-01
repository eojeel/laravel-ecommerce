<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = request()->user();

        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = Cart::getProductsCartItems();

        $line_items = [];
        $totalPrice = 0;
        foreach ($products as $product) {
            $qty = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $qty;
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $qty,
            ];
        }

        $orderData = [
            'total_price' => $totalPrice,
            'status' => OrderStatus::unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];

        $order = Order::create($orderData);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'customer_creation' => 'always',
            'line_items' => $line_items,
            'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);

        $paymentData = [
            'order_id' => $order->id,
            'amount' => $totalPrice,
            'status' => PaymentStatus::pending,
            'type' => 'cc',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id,
        ];

        Payment::create($paymentData);

        CartItem::where(['user_id' => $user->id])->delete();

        return $session->url;
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');

        try {
            $session = Session::retrieve($session_id);
            if (! $session) {
                return Inertia::render('Checkout/Failure', ['error' => 'Unable to retrieve session']);
            }

            $payment = Payment::query()->where(['session_id' => $session->id, 'status' => PaymentStatus::pending])->first();

            if (! $payment || $payment->status != PaymentStatus::pending->value) {
                return Inertia::render('Checkout/Failure', ['error' => 'Unable to retrieve Payment']);
            }

            $payment->status = PaymentStatus::paid;
            $payment->update();

            $order = $payment->order;
            $order->status = OrderStatus::paid;
            $order->update();

            $customer = Customer::retrieve($session->customer);

            $line_items = Session::allLineItems($session->id, ['limit' => 5]);

            return Inertia::render('Checkout/Success', [
                'customer' => $customer,
                'order' => $line_items->data,
            ]);
        } catch (\Exception $e) {
            return Inertia::render('Checkout/Failure', ['error' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        dd($request->all());

        return Inertia::render('Checkout/Failure');
    }

    public function checkoutWithSessionId($id, Request $request)
    {
        $order = Order::query()->where(['id' => $id])->with('payment')->first();
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $session = Session::retrieve($order->payment->session_id);
    }
}
