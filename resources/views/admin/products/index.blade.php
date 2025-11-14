@extends('layout.admin')

@section('title', 'Products')

@section('content')
    <div class="bg-white rounded-lg border p-4">
        <h2 class="font-semibold mb-3">Products</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Price</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $p->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->price ?? '—' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $p->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
