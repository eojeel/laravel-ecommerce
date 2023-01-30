<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = request()->user();

        $stripe = new StripeClient(getenv('STRIPE_SECRET_KEY'));

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

        $paymentData = [
            'order_id' => $order->id,
            'amount' => $totalPrice,
            'status' => PaymentStatus::pending,
            'type' => 'stripe',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id,
        ];

        Payment::create($paymentData);

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => $line_items,
            'success_url' => route('cart.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.failure', [], true),
        ]);

        return $session->url;
    }

    public function success(Request $request)
    {
        $stripe = new StripeClient(getenv('STRIPE_SECRET_KEY'));
        $session = $request->get('session_id');

        try {
            $session = $stripe->checkout->sessions->retrieve($session);
            if (! $session) {
                return Inertia::render('Checkout/Failure', ['error' => 'Unable to retrieve session']);
            }

            $payment = Payment::query()->where(['session_id' => $session->id, 'status' => PaymentStatus::pending])->get();
            if (! $payment || $payment->status != PaymentStatus::pending->value) {
                return Inertia::render('Checkout/Failure', ['error' => 'Unable to retrieve Payment']);
            }
            $payment->status = PaymentStatus::paid;
            $payment->update();

            $order = $payment->order;
            $order->status = OrderStatus::paid;
            $order->update();

            $customer = $stripe->customer->retrieve($session->customer);
            $line_items = $stripe->checkout->sessions->allLineItems($session, ['limit' => 5]);

            return Inertia::render('Checkout/Success', [
                'customer' => $customer,
                'order' => $line_items,
            ]);
        } catch (\Exception $e) {
            return Inertia::render('Checkout/Failure', ['error' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        dd($request->all());

        return Inertia::render('Cart/Failure');
    }
}
