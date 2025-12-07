@extends('layout.admin')

@section('title', 'Coupons')

@section('content')
    <div
        class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 transition-colors duration-300">
        <div class="mb-3 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold dark:text-white">Coupons</h2>
                    <p class="text-sm text-gray-400">Manage all discount coupons</p>
                </div>
                <a href="{{ route('admin.coupons.create') }}"
                    class="inline-block bg-orange-600 text-white px-3 py-1 rounded">New Coupon</a>
            </div>

            <form action="{{ route('admin.coupons.index') }}" method="GET" class="mt-4">
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search coupons..."
                        class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-orange-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button type="submit" class="px-4 py-2 text-sm bg-orange-600 text-white rounded hover:bg-orange-700">
                        Search
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.coupons.index') }}"
                            class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-500">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="border-t border-gray-200 dark:border-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-4 text-sm">Code</th>
                        <th class="p-4 text-sm">Type</th>
                        <th class="p-4 text-sm">Value</th>
                        <th class="p-4 text-sm">Usage</th>
                        <th class="p-4 text-sm">Valid Period</th>
                        <th class="p-4 text-sm">Status</th>
                        <th class="p-4 text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr class="border-t border-gray-300 dark:border-gray-700 dark:text-gray-300">
                            <td class="p-4 text-sm font-semibold">{{ $coupon->code }}</td>
                            <td class="p-4 text-sm">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $coupon->type === 'percentage' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                    {{ ucfirst(str_replace('_', ' ', $coupon->type)) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm">
                                @if ($coupon->type === 'percentage')
                                    {{ number_format($coupon->value, 0) }}%
                                @else
                                    Rs {{ number_format($coupon->value, 2) }}
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                {{ $coupon->usage_count }}
                                @if ($coupon->usage_limit)
                                    / {{ $coupon->usage_limit }}
                                @else
                                    / ∞
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                <div>{{ $coupon->valid_from->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">to {{ $coupon->valid_until->format('M d, Y') }}</div>
                            </td>
                            <td class="p-4 text-sm">
                                @if ($coupon->valid_until < now())
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Expired
                                    </span>
                                @elseif ($coupon->valid_from > now())
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Scheduled
                                    </span>
                                @elseif ($coupon->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-sm">
                                <div class="flex items-center gap-3">
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

                                    <!-- View Button -->
                                    <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
                                        href="{{ route('admin.coupons.show', $coupon->id) }}">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border border-t border-gray-200 dark:border-gray-700 p-4">
                {{ $coupons->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
