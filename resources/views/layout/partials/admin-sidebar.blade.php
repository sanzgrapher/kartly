<aside class="w-64 bg-white border-r border-gray-200 min-h-screen">
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}"
            class="text-lg font-bold text-orange-600">{{ config('app.name', 'Kartly') }} Admin</a>
    </div>

    <nav class="px-4 pb-6">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-100' : '' }}">
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.users.*') ? 'bg-orange-100' : '' }}">
                    <span class="text-sm font-medium">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.categories.*') ? 'bg-orange-100' : '' }}">
                    <span class="text-sm font-medium">Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.products.*') ? 'bg-orange-100' : '' }}">
                    <span class="text-sm font-medium">Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.orders.*') ? 'bg-orange-100' : '' }}">
                    <span class="text-sm font-medium">Orders</span>
                </a>
            </li>


        </ul>
    </nav>
</aside>
