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
                            <td class="p-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $o->status->value == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($o->status->value == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                       ($o->status->value == 'shipped' ? 'bg-orange-100 text-orange-800' : 
                                       ($o->status->value == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                                    {{ ucfirst($o->status->value ?? 'n/a') }}
                                </span>
                            </td>
                            <td class="p-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $o->payment->payment_status->value == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($o->payment->payment_status->value == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($o->payment->payment_status->value ?? 'n/a') }}
                                </span>
                            </td>
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
