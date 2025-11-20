<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CartController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth'
        ];
    }

    // -------------------------------------------------------------
    // CART PAGE
    // -------------------------------------------------------------
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
        ]);
    }

    // -------------------------------------------------------------
    // ADD TO CART / BUY NOW
    // -------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'buy_now'    => 'nullable|boolean'
        ]);

        $cartItem = CartItem::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'user_id'    => Auth::id()
            ]);
        }

        // If Buy Now → redirect to cart page immediately
        if ($request->boolean('buy_now')) {
            return redirect()->route('cart.index');
        }

        // Normal add-to-cart → stay on page but reload Inertia props
        return redirect()->back()->with('success', 'Item added to cart.');
    }

    // -------------------------------------------------------------
    // UPDATE CART ITEM
    // -------------------------------------------------------------
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Redirect back → Inertia reloads Cart.vue with updated data
        return redirect()->back()->with('success', 'Quantity updated.');
    }

    // -------------------------------------------------------------
    // REMOVE ITEM FROM CART
    // -------------------------------------------------------------
    public function destroy(string $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        // Redirect back → Inertia reloads Cart.vue
        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    // -------------------------------------------------------------
    // CHECKOUT
    // -------------------------------------------------------------
    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        foreach ($cartItems as $item) {
            Order::create([
                'user_id'    => Auth::id(),
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'status'     => 'pending',
            ]);
        }

        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Checkout successful!');
    }
}
