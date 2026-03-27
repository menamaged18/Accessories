<?php

namespace App\Http\Controllers;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
//        $products = Product::all();
        $products = Product::paginate(4);
        $userCartProductIds = [];

        if (Auth::check()) {
            // Get the IDs of products already in the user's cart
            $userCartProductIds = CartItem::whereHas('cart', function($query) {
                $query->where('user_id', Auth::id());
            })->pluck('product_id')->toArray();
        }

        return view('products.index', compact('products', 'userCartProductIds'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath
        ]);

//        Product::create([
//            'name' => $request->name,
//            'description' => $request->description,
//            'price' => $request->price,
//        ]);

        return redirect('/')->with('success', 'Product added');
    }

}
