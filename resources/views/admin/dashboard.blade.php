@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-300">
            <div class="text-xs text-gray-500">Total Users</div>
            <div class="text-2xl font-semibold">{{ $stats['users'] ?? 'n/a' }}</div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-300">
            <div class="text-xs text-gray-500">Orders</div>
            <div class="text-2xl font-semibold">{{ $stats['orders'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-300">
            <div class="text-xs text-gray-500">Revenue</div>
            <div class="text-2xl font-semibold">{{ $stats['revenue'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-300">
            <div class="text-xs text-gray-500">Products</div>
            <div class="text-2xl font-semibold">{{ $stats['products'] ?? 'n/a' }}</div>
        </div>


        
    </div>

    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Recent Users</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Email</th>
                        <th class="px-3 py-2 text-sm">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers ?? [] as $user)
                        <tr class="border-t border-gray-300">
                            <td class="px-3 py-2 text-sm">{{ $user->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->email }}</td>
                            <td class="px-3 py-2 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Recent Products</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">Name</th>
                        <th class="px-3 py-2 text-sm">Price</th>
                        <th class="px-3 py-2 text-sm">Qty</th>
                        <th class="px-3 py-2 text-sm">Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentProducts ?? [] as $product)
                        <tr class="border-t border-gray-300">
                            <td class="px-3 py-2 text-sm">{{ $product->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $product->name }}</td>
                            <td class="px-3 py-2 text-sm">${{ number_format($product->price / 100, 2) }}</td>
                            <td class="px-3 py-2 text-sm">{{ $product->quantity }}</td>
                            <td class="px-3 py-2 text-sm">{{ $product->category->name ?? 'n/a' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
