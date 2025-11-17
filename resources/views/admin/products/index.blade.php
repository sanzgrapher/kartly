@extends('layout.admin')

@section('title', 'Products')

@section('content')
    <div class="mt-8 bg-white rounded-lg border border-gray-300">
        <div class="mb-3 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold">Products</h2>
                    <p class=" text-sm text-gray-400">Manage all products</p>
                </div>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-block bg-orange-600 text-white px-3 py-1 rounded">
                    + New Product</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="border-t border-gray-200">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Image</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Price</th>
                        <th class="p-4 text-sm">Stock</th>
                        <th class="p-4 text-sm">Created</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $p)
                        <tr class="border-t border-gray-300  ">
                            <td class="p-4 text-sm">{{ $p->id }}</td>
                            <td class="p-4 text-sm">
                                <img src="{{ $p->image_url }}" alt="{{ $p->name }}"
                                    class="w-16 h-12 object-cover rounded">
                            </td>
                            <td class="p-4 text-sm">{{ $p->name }}</td>
                            <td class="p-4 text-sm">
                                Rs {{ $p->price }}
                            </td>
                            <td class="p-4 text-sm">
                                @if ($p->stock_status == 'In Stock')
                                    <span class="text-green-600 font-medium">{{ $p->stock_status }}</span>
                                @elseif($p->stock_status == 'Low Stock')
                                    <span class="text-yellow-600 font-medium">{{ $p->stock_status }}</span>
                                @else
                                    <span class="text-red-600 font-medium">{{ $p->stock_status }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">{{ $p->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.products.show', $p->id) }}" title="View">View</a>

                                <a class="px-2 py-1 text-xs text-white rounded bg-amber-500 hover:bg-amber-600"
                                    href="{{ route('admin.products.edit', $p->id) }}" title="Edit">Edit</a>

                                <form class="inline" action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600"
                                        type="submit" title="Delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 p-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
