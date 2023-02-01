<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $orders = Order::query()->where(['created_by' => $user->id])->with('payment')->paginate(10);

        return inertia('Order/Index', [
            'orders' => $orders,
        ]);
    }

    public function view()
    {
    }
}
