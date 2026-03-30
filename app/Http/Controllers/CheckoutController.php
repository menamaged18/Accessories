<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('orders.checkout', compact('cart'));
    }

    // Process the order
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        $cart = Cart::with('items.product')
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'phone' => $request->phone,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            OrderItems::create([
                'order_id'            => $order->id,
                'product_id'          => $item->product_id,
                'quantity'            => $item->quantity,
                // --- THE SNAPSHOTS ---
                'price'               => $item->product->price,
                'product_name'        => $item->product->name,
                'product_description' => $item->product->description,
                'product_image'       => $item->product->image,
            ]);
        }

        // Clear the cart
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }
}
