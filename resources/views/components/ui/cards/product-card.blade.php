@props(['product'])

<div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
	<div class="h-40 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center">
		<img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover h-full w-full" >
	</div>

	<div class="mt-3">
		<h3 class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
		<div class="text-sm text-gray-600">${{ number_format($product->price / 100, 2) }}</div>
		<div class="text-xs text-gray-500 mt-1">Qty: {{ $product->quantity }}</div>
		<div class="text-xs text-gray-500">Category: {{ $product->category->name ?? 'n/a' }}</div>
	</div>

	<div class="mt-3 flex items-center gap-2">
		<a href="{{ route('admin.products.edit', $product) }}" class="inline-block text-xs px-2 py-1 bg-orange-500 text-white rounded">Edit</a>
		<a href="{{ route('admin.products.show', $product) }}" class="inline-block text-xs px-2 py-1 border border-gray-200 rounded text-gray-700">View</a>
	</div>
</div>
