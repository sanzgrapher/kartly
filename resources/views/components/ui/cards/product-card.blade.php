@props(['product', 'url' => null])

@php
  $url = $url ?? route('products.show', $product->slug ?? $product->id);
@endphp

<a href="{{ $url }}" class="block bg-white rounded-lg border border-gray-200  hover:shadow-md transition-shadow" aria-label="View {{ $product->name }}">
    <div class="h-40 rounded-tl-lg rounded-tr-lg  bg-gray-100  overflow-hidden flex items-center justify-center">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
    </div>

    <div class="mt-2  pb-4 px-3">
        <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
        <div class="text-xs text-gray-500">{{ $product->category->name ?? 'n/a' }}</div>
        <div class="mt-4 font-bold text-sm text-green-600">Rs {{ $product->price }}</div>
        
    </div>
</a>
