@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-gray-200">
            <div class="text-sm font-medium text-blue-600">Total Users</div>
            <div class="text-2xl font-bold text-blue-900">{{ $stats['users'] ?? 'n/a' }}</div>
        </div>

        <div class="bg-yellow-50 p-4 rounded-lg border border-gray-200">
            <div class="text-sm font-medium text-yellow-600">Orders</div>
            <div class="text-2xl font-bold text-yellow-900">{{ $stats['orders'] ?? 'n/a' }}</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-gray-200">
            <div class="text-sm font-medium text-green-600">Revenue</div>
            <div class="text-2xl font-bold text-green-900">Rs {{$stats['revenue'] ?? 0 }}</div>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg border border-gray-200">
            <div class="text-sm font-medium text-purple-600">Products</div>
            <div class="text-2xl font-bold text-purple-900">{{ $stats['products'] ?? 'n/a' }}</div>
        </div>



    </div>
    <div class="mt-4">
        <h2 class="font-semibold mb-3">Recent Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($recentProducts ?? [] as $product)
                <x-ui.cards.product-card :product="$product" />
            @endforeach
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg border border-gray-300 x">
        <div class="mb-3 p-3">
            <h2 class="font-semibold ">Recent Users</h2>
            <p class=" text-sm text-gray-400">Recently Joined Users</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">Name</th>
                        <th class="p-4 text-sm">Email</th>
                        <th class="p-4 text-sm">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers ?? [] as $user)
                        <tr class="border-t  border-gray-300">
                            <td class="p-4 text-sm">{{ $user->id }}</td>
                            <td class="p-4 text-sm">{{ $user->name }}</td>
                            <td class="p-4 text-sm">{{ $user->email }}</td>
                            <td class="p-4 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
