<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public static function middleware(): array
    {
        return ['auth'];
    }

    // -------------------------------------------------------------
    // 1. CART PAGE (GET /cart)
    // -------------------------------------------------------------
    public function index()
    {
        // ✅ Requirement: Visiting /cart should show DB items only.
        // We explicitly clear any lingering Buy Now session here.
        session()->forget('buy_now');

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
            'mode'      => 'cart', // Tell frontend this is the shopping cart
        ]);
    }

    // -------------------------------------------------------------
    // 2. CHECKOUT VIEW (GET /checkout)
    // -------------------------------------------------------------
    public function checkoutView()
    {
        // A. BUY NOW FLOW
        if (session()->has('buy_now')) {
            $buyNow = session('buy_now');
            $product = Product::findOrFail($buyNow['product_id']);

            return Inertia::render('Cart', [ // Reusing the 'Cart' component for UI consistency
                'cartItems' => collect([
                    (object)[
                        'id'       => 0, // Virtual ID for session item
                        'quantity' => $buyNow['quantity'],
                        'product'  => $product
                    ]
                ]),
                'mode' => 'buy_now' // Tell frontend this is Buy Now checkout
            ]);
        }

        // B. NORMAL CART CHECKOUT FLOW
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
            'mode'      => 'checkout' // Tell frontend this is Standard checkout
        ]);
    }

    // -------------------------------------------------------------
    // 3. ADD TO CART / BUY NOW (POST /cart)
    // -------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'buy_now'    => 'nullable|boolean'
        ]);

        // ✅ BUY NOW LOGIC
        if ($request->boolean('buy_now')) {
            session([
                'buy_now' => [
                    'product_id' => $request->product_id,
                    'quantity'   => $request->quantity,
                ]
            ]);

            // Requirement: Redirects to checkout, not cart
            return redirect()->route('checkout.view');
        }

        // ✅ NORMAL ADD TO CART LOGIC
        // Requirement: Buy Now session should be cleared
        session()->forget('buy_now');

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
                'user_id'    => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart.');
    }

    // -------------------------------------------------------------
    // 4. PROCESS PAYMENT (POST /checkout)
    // -------------------------------------------------------------
    public function checkoutProcess()
    {
        // A. PROCESS BUY NOW
        if (session()->has('buy_now')) {
            $buyNow = session('buy_now');

            Order::create([
                'user_id'    => Auth::id(),
                'product_id' => $buyNow['product_id'],
                'quantity'   => $buyNow['quantity'],
                'status'     => 'pending',
            ]);

            session()->forget('buy_now');

            // Note: We do NOT delete from DB Cart here. 
            // Buy Now is a separate transaction.

            return redirect()->route('orders.index')->with('success', 'Order placed!');
        }

        // B. PROCESS NORMAL CART
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
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

        return redirect()->route('orders.index')->with('success', 'Orders placed successfully!');
    }

    // -------------------------------------------------------------
    // UPDATE QUANTITY
    // -------------------------------------------------------------
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Virtual ID 0 = Buy Now Session
        if ($id == '0') {
            if (session()->has('buy_now')) {
                $buyNow = session('buy_now');
                $buyNow['quantity'] = $request->quantity;
                session(['buy_now' => $buyNow]);
            }
            return redirect()->back();
        }

        // Normal DB Item
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back();
    }

    // -------------------------------------------------------------
    // REMOVE ITEM
    // -------------------------------------------------------------
    public function destroy(string $id)
    {
        if ($id == '0') {
            session()->forget('buy_now');
            return redirect()->route('catalogue'); // Redirect away if cancelling buy now
        }

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed.');
    }

    public function cancel()
    {
        session()->forget('buy_now');
        return redirect()->route('cart.index');
    }
}
