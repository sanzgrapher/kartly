<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartIcon extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-updated')]
    public function updateCartCount()
    {
        if (Auth::check()) {
            $this->cartCount = Auth::user()->cart?->cartItem()->count() ?? 0;
        } else {
            $sessionId = session()->getId();
            $this->cartCount = Cart::where('session_id', $sessionId)->first()?->cartItem()->count() ?? 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
