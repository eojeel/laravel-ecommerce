<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (! Auth::check()) {
            return response('', 403);
        }

        $user = request()->user();

        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = Cart::getProductsCartItems();

        $orderItems = [];
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
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $product->price,
            ];
        }

        $orderData = [
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];

        $order = Order::create($orderData);

        foreach ($orderItems as $orderItem) {
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }

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

            $payment = Payment::query()
                ->where(['session_id' => $session_id])
                ->whereIn('status', [PaymentStatus::pending, PaymentStatus::paid])
                ->first();
            if (! $payment) {
                throw new NotFoundHttpException();
            }
            if ($payment->status === PaymentStatus::pending->value) {
                $this->updateOrderAndSession($payment);
            }

            $customer = Customer::retrieve($session->customer);
            $line_items = Session::allLineItems($session->id, ['limit' => 5]);

            return Inertia::render('Checkout/Success', [
                'customer' => $customer,
                'order' => $line_items->data,
            ]);
        } catch (NotFoundHttpException $e) {
            throw $e;
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

        if ($session->payment_status === 'paid') {
            self::updateOrderAndSession($order->payment);

            return route('orders.index');
        }

        return $session->url;
    }

    public function webhook()
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        $endpoint_secret = getenv('STRIPE_WEBHOOK_SECRET');

        return response(332);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

                // Handle the event
        switch ($event->type) {
            case 'checkout.session.commpleted':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Payment::query()
                    ->where(['session_id' => $sessionId, 'status' => PaymentStatus::pending])
                    ->first();
                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }

            default:
                echo 'Received unknown event type '.$event->type;
        }

        return response('', 200);
    }

    private function updateOrderAndSession(Payment $payment)
    {
        $payment->status = PaymentStatus::paid;
        $payment->update();

        $order = $payment->order;
        $order->status = OrderStatus::Paid->value;
        $order->update();
    }
}
