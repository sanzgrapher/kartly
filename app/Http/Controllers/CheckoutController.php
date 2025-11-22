<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use App\Models\Payment;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Services\Payment\EsewaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected EsewaService $esewaService;

    public function __construct(EsewaService $esewaService)
    {
        $this->esewaService = $esewaService;
    }
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

        try {
            DB::beginTransaction();

            $shippingAddress = $user->addresses()->findOrFail($data['address_id']);
            $shippingAddressString = $this->formatAddressString($shippingAddress);

            // Create Order
            $order = $user->orders()->create([
                'status' => OrderStatus::PENDING,
                'shipping_address' => $shippingAddressString,
            ]);

            $cartItems = $cart->cartItem()->get();
            $subtotal = 0;

            foreach ($cartItems as $item) {
                // Lock the product row for update to prevent race conditions
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if (!$product) {
                    throw new \Exception("Product not found: " . $item->product_id);
                }

                if ($product->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for product: " . $product->name);
                }

                // Deduct stock
                $product->decrement('quantity', $item->quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'amount_per_item' => $product->price,
                    'quantity' => $item->quantity,
                ]);

                $subtotal += $product->price * $item->quantity;
            }

            $paymentMethod = PaymentMethod::from($data['payment_method']);

            if ($paymentMethod === PaymentMethod::ESEWA) {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $paymentMethod,
                    'payment_status' => PaymentStatus::PENDING,
                    'amount' => $subtotal,
                ]);

                $cart->cartItem()->delete();
                
                DB::commit();

                $this->esewaService->initiatePayment($order, $subtotal);
                return;
            }

            $paymentStatus = PaymentStatus::PENDING;

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'amount' => $subtotal,
                'transaction_code' => $order->id . '_' . time(),
            ]);

            $cart->cartItem()->delete();
            
            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
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
