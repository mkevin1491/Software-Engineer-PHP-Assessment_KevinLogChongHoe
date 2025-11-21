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
        // 1. Fix Validation: Allow all statuses present in your frontend dropdown
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled,completed',
        ]);

        // 2. Security: Ensure the user owns this order
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // 3. Update
        $order->status = $request->status;
        $order->save();

        // 4. Fix Return: Redirect back so Inertia reloads the data
        return redirect()->back()->with('success', 'Order status updated!');
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
