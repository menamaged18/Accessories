<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add($productId)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Added to cart');
    }

    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        return view('cart.index', compact('cart'));
    }

    public function remove($itemId)
    {
        // Find the item and ensure it belongs to the logged-in user's cart
        $item = CartItem::whereHas('cart', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($itemId);

        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }

        return redirect()->back()->with('success', 'Item updated');
    }

    public function removeByProductId($productId)
    {
        // Get the user's cart
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            // Find and delete the cart item by product ID
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->delete();
        }

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function destroy($itemId)
    {
        CartItem::whereHas('cart', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($itemId)->delete();

        return redirect()->back()->with('success', 'Item removed');
    }
}
