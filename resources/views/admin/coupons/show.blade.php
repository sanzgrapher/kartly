@extends('layout.admin')

@section('title', 'Coupon Details')

@section('content')
    <!-- Coupon Details Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-6 mb-6 transition-colors duration-300">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold dark:text-white mb-2">{{ $coupon->code }}</h2>
                <div class="flex items-center gap-2">
                    @if ($coupon->is_active && $coupon->valid_from <= now() && $coupon->valid_until >= now())
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Active
                        </span>
                    @elseif (!$coupon->is_active)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                            Inactive
                        </span>
                    @elseif ($coupon->valid_until < now())
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Expired
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Scheduled
                        </span>
                    @endif
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $coupon->type === 'percentage' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                        {{ ucfirst(str_replace('_', ' ', $coupon->type)) }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Toggle Switch -->
                <form class="inline" action="{{ route('admin.coupons.toggleActive', $coupon->id) }}"
                    method="POST" onchange="this.submit()">
                    @csrf
                    @method('PATCH')
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" 
                            {{ $coupon->is_active ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </label>
                </form>

                <div class="flex gap-2">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                        class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">
                        Edit
                    </a>

                    @if ($coupon->usage_count > 0)
                        <span class="px-4 py-2 bg-gray-400 text-gray-200 rounded cursor-not-allowed"
                            title="Cannot delete coupon that has been used">
                            Delete
                        </span>
                    @else
                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.coupons.index') }}"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded dark:text-white hover:bg-gray-400 dark:hover:bg-gray-500">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Discount Value -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Discount Value</label>
                <p class="text-lg font-semibold dark:text-white">
                    @if ($coupon->type === 'percentage')
                        {{ number_format($coupon->value, 0) }}%
                    @else
                        Rs {{ number_format($coupon->value, 2) }}
                    @endif
                </p>
            </div>

            <!-- Min Purchase -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Min Purchase Amount</label>
                <p class="text-lg font-semibold dark:text-white">
                    @if ($coupon->min_purchase_amount)
                        Rs {{ number_format($coupon->min_purchase_amount, 2) }}
                    @else
                        <span class="text-gray-400">No minimum</span>
                    @endif
                </p>
            </div>

            <!-- Max Discount -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Max Discount Amount</label>
                <p class="text-lg font-semibold dark:text-white">
                    @if ($coupon->max_discount_amount)
                        Rs {{ number_format($coupon->max_discount_amount, 2) }}
                    @else
                        <span class="text-gray-400">No limit</span>
                    @endif
                </p>
            </div>

            <!-- Usage Count -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Usage Count</label>
                <p class="text-lg font-semibold dark:text-white">
                    {{ $coupon->usage_count }}
                    @if ($coupon->usage_limit)
                        / {{ $coupon->usage_limit }}
                        <span
                            class="text-sm text-gray-500">({{ number_format(($coupon->usage_count / $coupon->usage_limit) * 100, 1) }}%)</span>
                    @else
                        <span class="text-sm text-gray-500">/ Unlimited</span>
                    @endif
                </p>
            </div>

            <!-- Per User Limit -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Per User Limit</label>
                <p class="text-lg font-semibold dark:text-white">
                    @if ($coupon->per_user_limit)
                        {{ $coupon->per_user_limit }} times
                    @else
                        <span class="text-gray-400">Unlimited</span>
                    @endif
                </p>
            </div>

            <!-- Valid Period -->
            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Valid Period</label>
                <p class="text-sm font-semibold dark:text-white">
                    {{ $coupon->valid_from->format('M d, Y H:i') }}
                </p>
                <p class="text-sm dark:text-gray-300">
                    to {{ $coupon->valid_until->format('M d, Y H:i') }}
                </p>
                @if ($coupon->valid_from > now())
                    <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-2 font-medium">
                         Starts in {{ $coupon->valid_from->diffForHumans(['parts' => 2]) }}
                    </p>
                @elseif ($coupon->valid_until >= now() && $coupon->valid_from <= now())
                    <p class="text-sm text-green-600 dark:text-green-400 mt-2 font-medium">
                         Expires in {{ $coupon->valid_until->diffForHumans(['parts' => 2]) }}
                    </p>
                @elseif ($coupon->valid_until < now())
                    <p class="text-sm text-red-600 dark:text-red-400 mt-2 font-medium">
                         Expired {{ $coupon->valid_until->diffForHumans() }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_orders'] }}</div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Discount Given</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">Rs
                {{ number_format($stats['total_discount'], 2) }}</div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Unique Users</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['unique_users'] }}</div>
        </div>
        <div
            class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Discount/Order</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                @if ($stats['total_orders'] > 0)
                    Rs {{ number_format($stats['total_discount'] / $stats['total_orders'], 2) }}
                @else
                    Rs 0.00
                @endif
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div
        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 transition-colors duration-300">
        <div class="p-4 border-b border-gray-300 dark:border-gray-700">
            <h3 class="font-semibold dark:text-white">Orders Using This Coupon</h3>
            <p class="text-sm text-gray-400">Recent orders that applied this discount code</p>
        </div>

        @if ($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left">
                    <thead class="border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="p-4 text-sm">Order ID</th>
                            <th class="p-4 text-sm">Customer</th>
                            <th class="p-4 text-sm">Subtotal</th>
                            <th class="p-4 text-sm">Discount</th>
                            <th class="p-4 text-sm">Total</th>
                            <th class="p-4 text-sm">Date</th>
                            <th class="p-4 text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-t border-gray-300 dark:border-gray-700 dark:text-gray-300">
                                <td class="p-4 text-sm font-medium">#{{ $order->id }}</td>
                                <td class="p-4 text-sm">
                                    {{ $order->user->name ?? 'N/A' }}
                                    <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                                </td>
                                <td class="p-4 text-sm">Rs {{ number_format($order->subtotal ?? 0, 2) }}</td>
                                <td class="p-4 text-sm font-semibold text-green-600 dark:text-green-400">
                                    -Rs {{ number_format($order->discount_amount, 2) }}
                                </td>
                                <td class="p-4 text-sm font-semibold">Rs {{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-4 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="p-4 text-sm">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-200">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                    {{ $orders->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @else
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <p>No orders have used this coupon yet.</p>
            </div>
        @endif
    </div>
@endsection
