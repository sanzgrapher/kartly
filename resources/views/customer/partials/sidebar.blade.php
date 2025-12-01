<aside class="bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 rounded-l-lg h-full">
    <div class="p-6">
        <h2 class="text-lg font-bold text-orange-600 dark:text-orange-500">My Account</h2>
    </div>

    <nav class="px-4 pb-6">
        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Account</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium {{ request()->routeIs('customer.dashboard') ? 'bg-orange-200 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400' : '' }}">
                        Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium {{ request()->routeIs('orders.*') ? 'bg-orange-200 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400' : '' }}">
                        My Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('addresses.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium {{ request()->routeIs('addresses.*') ? 'bg-orange-200 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400' : '' }}">
                        Addresses
                    </a>
                </li>
                <li>
                    


                      <form class="flex  items-center gap-3 px-3 py-2 rounded-md text-red-700 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 transistion font-medium " action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                     >
                    Logout
                </button>
            </form>


                </li>




            </ul>
        </div>
    </nav>
</aside>
