<aside class="bg-white border-r border-gray-200 rounded-l-lg h-full">
    <div class="p-6">
        <h2 class="text-lg font-bold text-orange-600">My Account</h2>
    </div>

    <nav class="px-4 pb-6">
        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Account</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 text-gray-700 font-medium {{ request()->routeIs('customer.dashboard') ? 'bg-orange-200 text-orange-600' : '' }}">
                        Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 text-gray-700 font-medium {{ request()->routeIs('orders.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        My Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('addresses.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 text-gray-700 font-medium {{ request()->routeIs('addresses.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        Addresses
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
