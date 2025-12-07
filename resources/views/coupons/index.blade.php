@extends('layout.public')

@section('title', 'Active Coupons')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded overflow-hidden shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl sm:text-3xl font-semibold dark:text-white">Active Coupons</h1>
        </div>

        <div class="p-6">
            @if ($coupons->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">No active coupons available at the moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($coupons as $coupon)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Code</p>
                                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $coupon->code }}</p>
                                </div>
                                <button onclick="copyCouponCode('{{ $coupon->code }}')"
                                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors"
                                    title="Copy code">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <p>
                                    @if ($coupon->type === 'percentage')
                                        <span class="font-semibold text-orange-600">{{ $coupon->value }}% OFF</span>
                                    @else
                                        <span class="font-semibold text-orange-600">Rs{{ number_format($coupon->value, 2) }}
                                            OFF</span>
                                    @endif
                                </p>

                                @if ($coupon->min_purchase_amount)
                                    <p>Min. purchase: Rs{{ number_format($coupon->min_purchase_amount, 2) }}</p>
                                @endif

                                @if ($coupon->max_discount_amount)
                                    <p>Max. discount: Rs{{ number_format($coupon->max_discount_amount, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyCouponCode(code) {
            const textArea = document.createElement('textarea');
            textArea.value = code;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                alert('Copied: ' + code);
            } catch (err) {
                alert('Code: ' + code);
            }
            document.body.removeChild(textArea);
        }
    </script>
@endsection
