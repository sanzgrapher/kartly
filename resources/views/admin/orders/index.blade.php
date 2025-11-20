@extends('layout.admin')

@section('title', 'Orders')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-medium text-blue-600">Total Orders</h3>
            <p class="text-2xl font-bold text-blue-900">{{ $totalOrders }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-medium text-green-600">Total Revenue</h3>
            <p class="text-2xl font-bold text-green-900">Rs {{ $totalRevenue }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-medium text-yellow-600">Pending Orders</h3>
            <p class="text-2xl font-bold text-yellow-900">{{ $pendingOrders }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-medium text-purple-600">Completed Payments</h3>
            <p class="text-2xl font-bold text-purple-900">{{ $completedPayments }}</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg border border-gray-300">

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200">
                    <tr>
                        <th class="p-4 text-sm">ID</th>
                        <th class="p-4 text-sm">User</th>
                        <th class="p-4 text-sm">Total</th>
                        <th class="p-4 text-sm">Order Status</th>
                        <th class="p-4 text-sm">Payment Status</th>
                        <th class="p-4 text-sm">Payment Method</th>
                        <th class="p-4 text-sm">Created</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>



                <tbody>
                    @foreach ($orders as $o)
                        <tr class="border-t  border-gray-300">
                            <td class="p-4 text-sm">{{ $o->id }}</td>

                            <td class="p-4 text-sm">{{ $o->user->name ?? 'n/a' }}</td>
                            <td class="p-4 text-sm">Rs {{ $o->total }}</td>
                            <td
                                class="p-4 text-sm {{ $o->status == 'pending' ? 'text-yellow-600' : ($o->status == 'processing' ? 'text-blue-600' : ($o->status == 'shipped' ? 'text-orange-600' : ($o->status == 'delivered' ? 'text-green-600' : 'text-red-600'))) }}">
                                {{ $o->status ?? 'n/a' }}</td>
                            <td
                                class="p-4 text-sm {{ $o->payment->payment_status == 'pending' ? 'text-yellow-600' : ($o->payment->payment_status == 'completed' ? 'text-green-600' : 'text-red-600') }}">
                                {{ $o->payment->payment_status ?? 'n/a' }}</td>
                            <td
                                class="p-4 text-sm {{ $o->payment->payment_method == 'credit_card' ? 'text-blue-600' : ($o->payment->payment_method == 'paypal' ? 'text-blue-600' : 'text-green-600') }}">
                                {{ $o->payment->payment_method ?? 'n/a' }}</td>
                            <td class="p-4 text-sm">{{ $o->created_at->format('M d, Y') }}</td>
                            <td class="flex px-4  py-2 space-x-2">
                                <a class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600"
                                    href="{{ route('admin.orders.show', $o->id) }}" title="View">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 p-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
