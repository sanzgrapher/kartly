<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;
use App\Services\Products\Contracts\RecommendationServiceInterface;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $maxStock;
    public $stockStatus;
    public $showQuantitySelector = true;
    public $showSuccess = false;
    public $showError = false;

    protected $rules = [
        'quantity' => 'required|integer|min:1',
    ];

    protected CartService $cartService;
    protected RecommendationServiceInterface $recommendationService;

    public function boot(CartService $cartService, RecommendationServiceInterface $recommendationService)
    {
        $this->cartService = $cartService;
        $this->recommendationService = $recommendationService;
    }

    public function mount($productId, $maxStock, $stockStatus = 'In Stock', $showQuantitySelector = true)
    {
        $this->productId = $productId;
        $this->maxStock = $maxStock;
        $this->stockStatus = $stockStatus;
        $this->showQuantitySelector = $showQuantitySelector;
    }

    public function increase()
    {
        if ($this->quantity < $this->maxStock) {
            $this->quantity++;
        }
    }

    public function decrease()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $this->validate();

        $result = $this->cartService->addToCart($this->productId, $this->quantity);

        if ($result['status']) {
            $this->recommendationService->trackInteraction(
                $this->productId,
                Auth::id(),
                'cart'
            );

            $this->dispatch('cart-updated');

            $this->showSuccess = true;
            $this->showError = false;

            $this->dispatch('reset-cart-button', delay: 1000);

            if (!$this->showQuantitySelector) {
                $this->quantity = 1;
            }
        } else {
            $this->showError = true;
            $this->showSuccess = false;

            $this->dispatch('reset-cart-button', delay: 1000);
        }
    }

    public function resetButton()
    {
        $this->showSuccess = false;
        $this->showError = false;
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
