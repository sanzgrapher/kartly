<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use App\Services\Products\Contracts\RecommendationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(
        CartService $cartService,
        private RecommendationServiceInterface $recommendationService
    ) {
        $this->cartService = $cartService;
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
        }

        $cart = $this->cartService->getCart();
        $cartItems = $cart->cartItem()->with('product')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->cartService->addToCart($request->product_id, $request->quantity);

        if (!$result['status']) {
            return back()->with('error', $result['message']);
        }

        $this->recommendationService->trackInteraction(
            $request->product_id,
            auth()->id(),
            'cart'
        );

        return back()->with('success', $result['message']);
    }
}
