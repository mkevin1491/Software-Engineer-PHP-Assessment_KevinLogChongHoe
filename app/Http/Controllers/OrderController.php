<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        // Load orders with product details
        $orders = Order::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('OrderList', [
            'orders' => $orders,
        ]);
    }

    /**
     * Update the status of an order.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'status' => $order->status]);
    }

    /**
     * Optional: Show a single order.
     */
    public function show($id)
    {
        $order = Order::with('product')->findOrFail($id);

        return Inertia::render('OrderDetail', [
            'order' => $order,
        ]);
    }
}
