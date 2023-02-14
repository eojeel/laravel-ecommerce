<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $orders = Order::query()->where(['created_by' => $user->id])->with('payment')->get();

        return inertia('Order/Index', [
            'orders' => $orders,
        ]);
    }

    public function view(Order $order)
    {
        /** @var User $user */
        $user = request()->user();

        if($order->created_by !== $user->id)
        {
            throw new UnauthorizedException('You are not authorized to view this order');
        }

        dd($order);

        return inertia('Order/View', [
            'order' => $order
        ]);
    }
}
