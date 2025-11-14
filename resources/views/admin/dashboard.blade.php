@extends('layout.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <div class="text-xs text-gray-500">Total Users</div>
            <div class="text-2xl font-semibold">{{ $stats['users'] ?? '—' }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <div class="text-xs text-gray-500">Orders</div>
            <div class="text-2xl font-semibold">{{ $stats['orders'] ?? '—' }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <div class="text-xs text-gray-500">Revenue</div>
            <div class="text-2xl font-semibold">{{ $stats['revenue'] ?? '—' }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg border p-4">
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
                    @foreach ($recentUsers ?? [] as $u)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $u->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $u->name }}</td>
                            <td class="px-3 py-2 text-sm">{{ $u->email }}</td>
                            <td class="px-3 py-2 text-sm">{{ $u->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
