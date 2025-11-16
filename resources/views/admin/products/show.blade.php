@extends('layout.admin')

@section('title', 'Product')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600">{{ optional($product->category)->name ?? 'n/a' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.edit', $product->id) }}"
                    class="px-3 py-1 bg-amber-500 text-white rounded text-sm">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-1 text-sm text-gray-600">Back</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="bg-gray-50 p-3 rounded">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full object-cover rounded">
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="mb-4">
                    <h3 class="font-medium text-sm text-gray-700 mb-1">Description</h3>
                    <div class="text-gray-800">{{ $product->description ?? 'n/a' }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <h4 class="text-xs text-gray-500">ID</h4>
                        <div class="mt-1">{{ $product->id }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Slug</h4>
                        <div class="mt-1">{{ $product->slug ?? 'n/a' }}</div>
                    </div>

                    <div>
                        <h4 class="text-xs text-gray-500">Price</h4>
                        <div class="mt-1">{{ $product->price ?? 'n/a' }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Quantity</h4>
                        <div class="mt-1">{{ $product->quantity }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Stock Status</h4>
                        <div class="mt-1">
                            @if($product->stock_status == 'In Stock')
                                <span class="text-green-600 font-medium">{{ $product->stock_status }}</span>
                            @elseif($product->stock_status == 'Low Stock')
                                <span class="text-yellow-600 font-medium">{{ $product->stock_status }}</span>
                            @else
                                <span class="text-red-600 font-medium">{{ $product->stock_status }}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs text-gray-500">Created</h4>
                        <div class="mt-1 text-sm text-gray-600">{{ $product->created_at->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <h4 class="text-xs text-gray-500">Updated</h4>
                        <div class="mt-1 text-sm text-gray-600">{{ $product->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
