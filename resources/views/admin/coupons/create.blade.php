@extends('layout.admin')

@section('title', 'Create Coupon')

@section('content')
    <div
        class="bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 p-4 transition-colors duration-300">
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Create New Coupon</h2>

        <form action="{{ route('admin.coupons.store') }}" method="POST" x-data="{ couponType: '{{ old('type', 'percentage') }}' }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Coupon Code -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Coupon Code <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', '') }}"
                        maxlength="10"
                        oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white uppercase"
                        placeholder="e.g., SAVE20" required>
                    <p class="text-xs text-gray-500 mt-1">Max 10 characters, uppercase letters and numbers only (no spaces)</p>
                    @error('code')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coupon Type -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Type <span
                            class="text-red-500">*</span></label>
                    <select name="type" x-model="couponType"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed_amount">Fixed Amount</option>
                    </select>
                    @error('type')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Value -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Value <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="value" value="{{ old('value', '') }}" step="0.01" min="0"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="e.g., 20 for 20% or Rs 100" required>
                    <p class="text-xs text-gray-500 mt-1">Percentage (0-100) or fixed amount in Rs</p>
                    @error('value')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Min Purchase Amount -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Min Purchase Amount</label>
                    <input type="number" name="min_purchase_amount" value="{{ old('min_purchase_amount', '') }}"
                        step="0.01" min="0"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="e.g., 500">
                    <p class="text-xs text-gray-500 mt-1">Minimum order value to use this coupon</p>
                    @error('min_purchase_amount')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Max Discount Amount -->
                <div class="mb-4" x-show="couponType === 'percentage'">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Max Discount Amount</label>
                    <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount', '') }}"
                        step="0.01" min="0"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="e.g., 1000">
                    <p class="text-xs text-gray-500 mt-1">Maximum discount amount (caps the discount for percentage coupons)
                    </p>
                    @error('max_discount_amount')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Usage Limit -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Total Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', '') }}" min="0"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Leave empty for unlimited">
                    <p class="text-xs text-gray-500 mt-1">Total times this coupon can be used</p>
                    @error('usage_limit')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Per User Limit -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Per User Limit</label>
                    <input type="number" name="per_user_limit" value="{{ old('per_user_limit', '') }}" min="0"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Leave empty for unlimited">
                    <p class="text-xs text-gray-500 mt-1">Times each user can use this coupon</p>
                    @error('per_user_limit')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Valid From -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Valid From <span
                            class="text-red-500">*</span></label>
                    <input type="datetime-local" name="valid_from" id="valid_from" value="{{ old('valid_from', '') }}"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Must be today or later</p>
                    @error('valid_from')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Valid Until -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Valid Until <span
                            class="text-red-500">*</span></label>
                    <input type="datetime-local" name="valid_until" id="valid_until" value="{{ old('valid_until', '') }}"
                        class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Must be after start date</p>
                    @error('valid_until')
                        <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Is Active -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm dark:text-gray-300">Active</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Inactive coupons cannot be used even within valid dates</p>
            </div>

            <div class="mt-6 flex space-x-2">
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Create
                    Coupon</button>
                <a href="{{ route('admin.coupons.index') }}"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded dark:text-white hover:bg-gray-400 dark:hover:bg-gray-500">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.querySelector('select[name="type"]');
            const valueInput = document.querySelector('input[name="value"]');
            const usageLimit = document.querySelector('input[name="usage_limit"]');
            const perUserLimit = document.querySelector('input[name="per_user_limit"]');
            const validFrom = document.getElementById('valid_from');
            const validUntil = document.getElementById('valid_until');

            // Dynamic validation for percentage type
            if (typeSelect && valueInput) {
                typeSelect.addEventListener('change', function() {
                    if (this.value === 'percentage') {
                        valueInput.setAttribute('max', '100');
                    } else {
                        valueInput.removeAttribute('max');
                    }
                });

                // Trigger on load
                if (typeSelect.value === 'percentage') {
                    valueInput.setAttribute('max', '100');
                }
            }

            // Validate per_user_limit doesn't exceed usage_limit
            if (usageLimit && perUserLimit) {
                function validateLimits() {
                    const usageVal = parseInt(usageLimit.value) || 0;
                    const perUserVal = parseInt(perUserLimit.value) || 0;

                    if (usageVal > 0 && perUserVal > usageVal) {
                        perUserLimit.setCustomValidity('Per user limit cannot exceed total usage limit');
                    } else {
                        perUserLimit.setCustomValidity('');
                    }
                }

                usageLimit.addEventListener('input', validateLimits);
                perUserLimit.addEventListener('input', validateLimits);
            }

            // Date validation - valid_until must be after valid_from
            if (validFrom && validUntil) {
                validFrom.addEventListener('change', function() {
                    if (this.value) {
                        validUntil.min = this.value;

                        // If valid_until is before valid_from, clear it
                        if (validUntil.value && validUntil.value <= this.value) {
                            validUntil.value = '';
                        }
                    }
                });

                validUntil.addEventListener('change', function() {
                    if (validFrom.value && this.value <= validFrom.value) {
                        this.setCustomValidity('End date must be after start date');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });
    </script>
@endsection
