@props(['product'])

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center h-96">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>

    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>

        <p class="text-sm text-gray-600 mb-4">
            @if ($product->category)
                <a href="{{ route('categories.show', $product->category->slug) }}"
                    class="text-orange-600 hover:underline px-3">
                    {{ $product->category->name }}
                </a>
            @endif
            |

            @if ($product->stock_status == 'In Stock')
                <span class="inline-block px-3 py-1 text-green-800 rounded-full text-sm">
                    {{ $product->stock_status }}
                </span>
            @elseif($product->stock_status == 'Low Stock')
                <span class="inline-block px-3 py-1 text-yellow-800 rounded-full text-sm">
                    {{ $product->stock_status }}
                </span>
            @else
                <span class="inline-block px-3 py-1 text-red-800 rounded-full text-sm">
                    {{ $product->stock_status }}
                </span>
            @endif

            |

            <span class="font-semibold px-3 text-gray-800">{{ $product->quantity }}</span>
        </p>

        @if ($product->description)
            <div class="border-t py-6 border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Description</h2>
                <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none">{!! $product->description !!}</div>
            </div>
        @endif

        <div class="mb-6">
            <p class="text-4xl text-orange-600">Rs {{ number_format($product->price, 0) }}</p>
        </div>

        <div class="mb-6">
            @livewire('add-to-cart', [
                'productId' => $product->id,
                'maxStock' => $product->quantity,
                'stockStatus' => $product->stock_status,
                'showQuantitySelector' => true,
            ])
        </div>
    </div>
</div>
