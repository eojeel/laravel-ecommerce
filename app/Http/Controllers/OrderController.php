<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $orders = Order::query()->where(['created_by' => $user->id])->paginate(10);

        return inertia('Order/Index', [
            'orders' => compact('orders')
        ]);
    }

    public function view()
    {

    }
}
