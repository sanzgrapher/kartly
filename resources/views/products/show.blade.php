@extends('layout.public')

@section('title', $product->name . ' - Shop')

@section('content')

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
            <p class="text-red-800 font-semibold mb-2">Error:</p>
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded">
            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded">
            <p class="text-red-800 font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    {{-- <x-ui.product.detail-view :product="$product" /> --}}
    <x-ui.product.detail-view-v2 :product="$product" />

    @if ($relatedProducts->isNotEmpty())
        <div class="border-t pt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($relatedProducts as $relatedProduct)
                    <x-ui.cards.product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    @endif
@endsection
