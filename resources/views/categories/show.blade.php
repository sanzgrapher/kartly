@extends('layout.public')

@section('title', $category->name . ' - Shop')

@section('content')
  

     <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $category->name }}</h1>
        <p class="text-gray-600">
            Showing <span class="font-semibold">{{ $products->total() }}</span>
            product{{ $products->total() !== 1 ? 's' : '' }}
        </p>
    </div>

     @if ($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @foreach ($products as $product)
                <x-ui.cards.product-card :product="$product" />
            @endforeach
        </div>

         <div class="flex justify-center mt-12">
            {{ $products->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                </path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-1">No products available</h3>
          
            <a href="{{ route('home') }}"
                class="inline-block px-6 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                Back to Home
            </a>
        </div>
    @endif
@endsection
