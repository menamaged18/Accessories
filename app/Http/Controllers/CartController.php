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

    }
}
