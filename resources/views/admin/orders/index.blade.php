@extends('layout.admin')

@section('title', 'Orders')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">Rs {{ $totalRevenue }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Orders</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingOrders }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Payments</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedPayments }}</p>
        </div>
    </div>

    <div
        class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 transition-colors duration-300">

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="  border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
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



                <tbody class="dark:text-gray-300">
                    @foreach ($orders as $o)
                        <tr class="border-t  border-gray-300 dark:border-gray-700">
                            <td class="p-4 text-sm">{{ $o->id }}</td>

                            <td class="p-4 text-sm">{{ $o->user->name ?? 'n/a' }}</td>
                            <td class="p-4 text-sm">Rs {{ number_format($o->total, 2) }}</td>
                            <td class="p-4 text-sm">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $o->status->value == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($o->status->value == 'processing'
                                            ? 'bg-blue-100 text-blue-800'
                                            : ($o->status->value == 'shipped'
                                                ? 'bg-orange-100 text-orange-800'
                                                : ($o->status->value == 'delivered'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'))) }}">
                                    {{ ucfirst($o->status->value ?? 'n/a') }}
                                </span>
                            </td>
                            <td class="p-4 text-sm">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $o->payment->payment_status->value == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($o->payment->payment_status->value == 'completed'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($o->payment->payment_status->value ?? 'n/a') }}
                                </span>
                            </td>
                            <td class="p-4 text-sm">
                                @if ($o->payment && $o->payment->payment_method)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $o->payment->payment_method->badgeClass() }}">
                                        {{ $o->payment->payment_method->label() }}
                                    </span>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">{{ $o->created_at->format('M d, Y') }}</td>
                            <td class="p-4 text-sm">
                                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                    href="{{ route('admin.orders.show', $o->id) }}">
                                    View Details
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
