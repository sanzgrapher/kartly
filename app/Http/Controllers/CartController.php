<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        $cartItems = $cart->cartItem()->with('product')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);



        $cartItem = $cart->cartItem()->where('product_id', $data['product_id'])->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $data['quantity'];


            if ($product->quantity < $newQuantity) {
                return back()->with('error', 'Requested quantity exceeds available stock.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
        }

        return back()->with('success', 'Product added to cart successfully.');
    }
}
