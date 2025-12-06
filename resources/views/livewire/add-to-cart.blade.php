<div>
    @if ($showQuantitySelector)
         <div class="flex items-stretch w-full space-x-2" x-data="{ quantity: @entangle('quantity'), maxStock: {{ $maxStock }} }">
            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                <button type="button" wire:click="decrease"
                    :class="[
                        'h-full',
                        'rounded-l-lg',
                        'px-4 py-2 font-semibold',
                        quantity <= 1 ?
                        'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                        'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                    ]"
                    :disabled="quantity <= 1">
                    -
                </button>
                <input type="number" wire:model.live="quantity" min="1" max="{{ $maxStock }}"
                    class="w-14 px-2 py-2 text-center mx-1 focus:outline-none focus:ring-2 focus:ring-primary-500 border-0 text-xl font-semibold bg-transparent dark:text-white"
                    @disabled($stockStatus === 'Out of Stock')>
                <button type="button" wire:click="increase"
                    :class="[
                        'h-full',
                        'rounded-r-lg',
                        'px-4 py-2 font-semibold',
                        quantity >= maxStock ?
                        'bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed' :
                        'bg-gray-50 dark:bg-gray-700 hover:bg-primary-500 hover:text-white text-gray-700 dark:text-gray-200'
                    ]"
                    :disabled="quantity >= maxStock">
                    +
                </button>
            </div>
            <div class="w-full">
                <button type="button" wire:click="addToCart" wire:loading.attr="disabled"
                    :class="{
                        'border-green-500 dark:border-green-400 text-green-500 dark:text-green-400 bg-green-50 dark:bg-green-900/20': @js($showSuccess),
                        'border-red-500 dark:border-red-400 text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/20': @js($showError),
                        'border-primary-500 dark:border-primary-400 text-primary-500 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20':
                            !@js($showSuccess) && !@js($showError)
                    }"
                    class="w-full h-full py-3 border font-semibold text-xl rounded-lg disabled:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50 transition-all"
                    @disabled($stockStatus == 'Out of Stock') x-data="{
                        resetTimer: null,
                        init() {
                            window.addEventListener('reset-cart-button', (event) => {
                                clearTimeout(this.resetTimer);
                                this.resetTimer = setTimeout(() => {
                                    @this.call('resetButton');
                                }, event.detail?.delay || 1000);
                            });
                        }
                    }">
                     <span wire:loading wire:target="addToCart" class="inline-flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Adding...</span>
                    </span>

                     @if ($showSuccess)
                        <span wire:loading.remove wire:target="addToCart" class="inline-flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Added!
                        </span>
                    @elseif($showError)
                        <span wire:loading.remove wire:target="addToCart" class="inline-flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Error
                        </span>
                    @else
                        <span wire:loading.remove wire:target="addToCart">Add to Cart</span>
                    @endif
                </button>
            </div>
        </div>
    @else
         <button type="button" wire:click="addToCart" wire:loading.attr="disabled"
            :class="{
                'border-green-500 dark:border-green-400 text-green-500 dark:text-green-400 bg-green-50 dark:bg-green-900/20': @js($showSuccess),
                'border-red-500 dark:border-red-400 text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/20': @js($showError),
                'border-primary-500 dark:border-primary-400 text-primary dark:text-primary-400 hover:bg-primary hover:text-white dark:hover:bg-primary-600 dark:hover:text-white':
                    !@js($showSuccess) && !@js($showError)
            }"
            class="p-2 bg-white dark:bg-gray-700 border rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed"
            @disabled($stockStatus == 'Out of Stock') aria-label="Add to cart" x-data="{
                resetTimer: null,
                init() {
                    window.addEventListener('reset-cart-button', (event) => {
                        clearTimeout(this.resetTimer);
                        this.resetTimer = setTimeout(() => {
                            @this.call('resetButton');
                        }, event.detail?.delay || 1000);
                    });
                }
            }">
             <span wire:loading wire:target="addToCart">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </span>

             @if ($showSuccess)
                <span wire:loading.remove wire:target="addToCart">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </span>
            @elseif($showError)
                <span wire:loading.remove wire:target="addToCart">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </span>
            @else
                <span wire:loading.remove wire:target="addToCart">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            @endif
        </button>
    @endif
</div>
