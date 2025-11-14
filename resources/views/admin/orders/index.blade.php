@extends('layout.admin')

@section('title', 'Orders')

@section('content')
    <div class="bg-white rounded-lg border border-gray-300 p-4">
        <h2 class="font-semibold mb-3">Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-3 py-2 text-sm">ID</th>
                        <th class="px-3 py-2 text-sm">User</th>
                        <th class="px-3 py-2 text-sm">Total</th>
                        <th class="px-3 py-2 text-sm">Created</th>
                        <th class="px-3 py-2 text-sm">Actions</th>
                    </tr>
                </thead>



                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">{{ $o->id }}</td>

                            <td class="px-3 py-2 text-sm">{{ $o->user->name ?? 'n/a' }}</td>
                            <td class="px-3 py-2 text-sm">
                                {{ $o->total }} </td>
                            <td class="px-3 py-2 text-sm">{{ $o->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4 py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.orders.show', $o->id) }}" title="View">
                                    View
                                </a>
                            </td>
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
