<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show a specific order for the logged-in user (Customer)
     */
    public function show(Order $order)
    {
        // Security: Ensure the user only sees their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show list of orders for the logged-in user (Customer)
     */
    public function showUserOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.userOrders', compact('orders'));
    }

    /**
     * Show ALL orders for Admins only
     */
    public function allOrders()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show a specific order for Admins (Bypasses user ownership check)
     */
    public function showAdminOrder(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
