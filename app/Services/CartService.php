<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            return Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();
        Log::info('CartService: getCart using Session ID: ' . $sessionId);

        $cart = Cart::where('session_id', $sessionId)->first();

        if ($cart) {
            Log::info('CartService: Found existing guest cart ID: ' . $cart->id);
        } else {
            Log::info('CartService: Creating new guest cart for Session ID: ' . $sessionId);
            $cart = Cart::create(['session_id'  => $sessionId]);
        }

        return $cart;
    }

    public function addToCart($productId, $quantity)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();
        $cartItem = $cart->cartItem()->where('product_id', $productId)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if ($product->quantity < $newQuantity) {
                return ['status' => false, 'message' => 'Requested quantity exceeds available stock.'];
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            if ($product->quantity < $quantity) {
                return ['status' => false, 'message' => 'Requested quantity exceeds available stock.'];
            }

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return ['status' => true, 'message' => 'Product added to cart successfully.'];
    }

    public function updateItem($cartItemId, $quantity)
    {
        $cart = $this->getCart();
        $cartItem = $cart->cartItem()->where('id', $cartItemId)->first();

        if (!$cartItem) {
            return ['status' => false, 'message' => 'Cart item not found.'];
        }

        $product = $cartItem->product;

        if ($product->quantity < $quantity) {
            return ['status' => false, 'message' => 'Requested quantity exceeds available stock.'];
        }

        $cartItem->update(['quantity' => $quantity]);

        return ['status' => true, 'message' => 'Cart item updated successfully.'];
    }

    public function removeItem($cartItemId)
    {
        $cart = $this->getCart();
        $cartItem = $cart->cartItem()->where('id', $cartItemId)->first();

        if (!$cartItem) {
            return ['status' => false, 'message' => 'Cart item not found.'];
        }

        $cartItem->delete();

        return ['status' => true, 'message' => 'Item removed from cart.'];
    }

    public function mergeGuestCart($sessionId = null)
    {
        $sessionId = $sessionId ?? Session::getId();
        Log::info('CartService: Merging cart for Session ID: ' . $sessionId);

        $guestCart = Cart::where('session_id', $sessionId)->with('cartItem.product')->first();

        if (!$guestCart) {
            Log::info('CartService: No guest cart found for Session ID: ' . $sessionId);
            return;
        }

        Log::info('CartService: Guest cart found. ID: ' . $guestCart->id);

        $user = Auth::user();
        if (!$user) {
            Log::error('CartService: No authenticated user found during merge.');
            return;
        }

        Log::info('CartService: Merging into User ID: ' . $user->id);

        $userCart = $user->cart;

        if (!$userCart) {
            Log::info('CartService: User has no cart. Assigning guest cart.');
             $guestCart->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
        } else {
            Log::info('CartService: User has cart (ID: ' . $userCart->id . '). Merging items.');
            
            foreach ($guestCart->cartItem as $guestItem) {
                $existingItem = $userCart->cartItem()->where('product_id', $guestItem->product_id)->first();
                $product = $guestItem->product;

                if ($existingItem) {
                    $newQuantity = $existingItem->quantity + $guestItem->quantity;

                    if ($newQuantity > $product->quantity) {
                        $newQuantity = $product->quantity;
                    }

                    $existingItem->update(['quantity' => $newQuantity]);
                    $guestItem->delete(); 
                } else {
                    $newQuantity = $guestItem->quantity;
                    if ($newQuantity > $product->quantity) {
                        $newQuantity = $product->quantity;
                    }

                    $guestItem->update([
                        'cart_id' => $userCart->id,
                        'quantity' => $newQuantity
                    ]);
                }
            }

            $guestCart->delete();
        }
    }
    public function validateCartStock()
    {
        $cart = $this->getCart();
        $cartItems = $cart->cartItem()->with('product')->get();
        $adjustedItems = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            if ($product->quantity < $item->quantity) {
                $oldQuantity = $item->quantity;
                $newQuantity = $product->quantity;

                if ($newQuantity > 0) {
                    $item->update(['quantity' => $newQuantity]);
                } else {
                    $item->delete(); 
                }

                $adjustedItems[] = [
                    'product_name' => $product->name,
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                ];
            }
        }

        return $adjustedItems;
    }
}
