@extends('layout.admin')

@section('title', 'Orders')

@section('content')
    <div class="bg-white rounded-lg border p-4">
        <h2 class="font-semibold mb-3">Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">User</th>
                        <th class="px-3 py-2 text-sm">Total</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $o->id }}</td>
                            <td class="px-3 py-2 text-sm">{{ $o->user->name ?? '—' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $o->total ?? '—' }}</td>
                            <td class="px-3 py-2 text-sm">{{ $o->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
