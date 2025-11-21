@extends('layout.public')

@section('title', 'Shop')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Shop</h1>
            <p class="mt-2 text-gray-600">Browse all products available in the store.</p>
        </div>
        <div>
            <!-- Optional filters / sort could go here -->
        </div>
    </div>

    @if ($products->isEmpty())
        <div class="py-12 text-center text-gray-500">No products available.</div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
            @foreach ($products as $product)
                <x-ui.cards.product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->links('pagination::tailwind') }}
        </div>
    @endif

@endsection
