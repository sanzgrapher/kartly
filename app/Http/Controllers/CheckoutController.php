<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Coupon;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Services\Payment\EsewaService;
use App\Services\Products\Contracts\RecommendationServiceInterface;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;
use App\Events\OrderCreated;

class CheckoutController extends Controller
{
    protected EsewaService $esewaService;
    protected CartService $cartService;
    protected CouponService $couponService;

    public function __construct(
        EsewaService $esewaService,
        CartService $cartService,
        CouponService $couponService,
        private RecommendationServiceInterface $recommendationService
    ) {
        $this->esewaService = $esewaService;
        $this->cartService = $cartService;
        $this->couponService = $couponService;
    }
    public function index()
    {
        $adjustedItems = $this->cartService->validateCartStock();

        if (!empty($adjustedItems)) {
            $message = 'Some items in your cart were updated due to stock availability: ';
            foreach ($adjustedItems as $item) {
                $message .= "{$item['product_name']} ({$item['old_quantity']} -> {$item['new_quantity']}), ";
            }
            session()->flash('error', rtrim($message, ', '));
            return redirect()->route('cart.index'); // Redirect back to cart to review changes
        }

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
            'coupon_code' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $shippingAddress = $user->addresses()->findOrFail($data['address_id']);
            $shippingAddressString = $this->formatAddressString($shippingAddress);

            $cartItems = $cart->cartItem()->get();
            $subtotal = 0;

            // Calculate subtotal first (before stock deduction)
            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->first();
                if (!$product) {
                    throw new \Exception("Product not found: " . $item->product_id);
                }
                $subtotal += $product->price * $item->quantity;
            }

            // Validate and apply coupon if provided
            $couponId = null;
            $discountAmount = 0;

            if (!empty($data['coupon_code'])) {
                $validation = $this->couponService->validateCoupon($data['coupon_code'], $user, $subtotal);

                if (!$validation['valid']) {
                    throw new \Exception($validation['message']);
                }

                $couponId = $validation['coupon']['id'];
                $discountAmount = $validation['discount_amount'];
            }

            $finalAmount = $subtotal - $discountAmount;

            // Create order with coupon
            $order = $user->orders()->create([
                'status' => OrderStatus::PENDING,
                'shipping_address' => $shippingAddressString,
                'coupon_id' => $couponId,
                'discount_amount' => $discountAmount,
                'subtotal' => $subtotal,
            ]);

            // Create order items and deduct stock
            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if (!$product) {
                    throw new \Exception("Product not found: " . $item->product_id);
                }

                if ($product->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for product: " . $product->name);
                }

                $product->decrement('quantity', $item->quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'amount_per_item' => $product->price,
                    'quantity' => $item->quantity,
                ]);

                $this->recommendationService->trackInteraction(
                    $item->product_id,
                    $user->id,
                    'purchase'
                );
            }

            // Record coupon usage if applied
            if ($couponId) {
                $this->couponService->recordUsage(
                    Coupon::find($couponId),
                    $user,
                    $order->id,
                    $discountAmount
                );
            }

            $paymentMethod = PaymentMethod::from($data['payment_method']);

            if ($paymentMethod === PaymentMethod::ESEWA) {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $paymentMethod,
                    'payment_status' => PaymentStatus::PENDING,
                    'amount' => $finalAmount,
                ]);

                $cart->cartItem()->delete();

                DB::commit();

                event(new OrderCreated($order));

                $this->esewaService->initiatePayment($order, $finalAmount);
                return;
            }

            $paymentStatus = PaymentStatus::PENDING;

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'amount' => $finalAmount,
                'transaction_code' => $order->id . '_' . time(),
            ]);

            $cart->cartItem()->delete();

            DB::commit();

            event(new OrderCreated($order));

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
