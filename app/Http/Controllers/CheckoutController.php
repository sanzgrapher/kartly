<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Payment;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart ?? null;

        if (!$cart || $cart->cartItem()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->cartItem()->with('product')->get();
        $addresses = $user->addresses;

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cart', 'cartItems', 'addresses', 'subtotal'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $cart = $user->cart;

        if (!$cart || $cart->cartItem()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cash_on_delivery,esewa',
        ]);


        $shippingAddress = $user->addresses()->findOrFail($data['address_id']);


        $cartItems = $cart->cartItem()->with('product')->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });


        $shippingAddress = $this->formatAddressString($shippingAddress);


        $order = $user->orders()->create([
            'status' => OrderStatus::PENDING,
            'shipping_address' => $shippingAddress,
        ]);


        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'amount_per_item' => $item->product->price,
                'quantity' => $item->quantity,
            ]);
        }

        $paymentMethod = PaymentMethod::from($data['payment_method']);
        $paymentStatus = $paymentMethod === PaymentMethod::ESEWA
            ? PaymentStatus::COMPLETED
            : PaymentStatus::PENDING;

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'amount' => $subtotal,
            'transaction_code' =>  $order->id . '_' . time(),
        ]);


        $cart->cartItem()->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }


    private function formatAddressString(Address $address): string
    {
        return implode(', ', array_filter([
            $address->street_address_1,
            $address->street_address_2,
            $address->city,
            $address->state,
            $address->country,
        ]));
    }
}
