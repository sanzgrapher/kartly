@extends('layout.admin')

@section('title', 'Products')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Products</h2>
            <a href="{{ route('admin.products.create') }}" class="inline-block bg-orange-600 text-white px-3 py-1 rounded">New
                Product</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Price</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                        <th class="px-3 py-2 text-sm">Actions</th>
                    </tr>
                </thead> 
                
                <tbody>
                    @foreach ($products as $p)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $p->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->price ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->created_at->format('M d, Y') }}</td>
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

            <div class="mt-4 ">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
