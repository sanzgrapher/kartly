<!-- Mobile overlay backdrop -->
<div id="sidebarBackdrop" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="adminSidebar"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 min-h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="p-6 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}"
            class="text-lg font-bold text-orange-600">{{ config('app.name', 'Kartly') }} Admin</a>
        <!-- Close button for mobile -->
        <button id="sidebarClose" class="lg:hidden text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <nav class="px-4 pb-6 overflow-y-auto" style="max-height: calc(100vh - 88px);">
        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">General</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.search.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.search.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Search</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.users.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Users</span>
                    </a>
                </li>
            </ul>
        </div>

        <hr class="border-t border-gray-200 my-2">

        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Site</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('about') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('about') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">About</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('contact') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Contact</span>
                    </a>
                </li>
            </ul>
        </div>

        <hr class="border-t border-gray-200 my-2">

        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Catalog</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.categories.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.products.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Products</span>
                    </a>
                </li>
            </ul>
        </div>

        <hr class="border-t border-gray-200 my-2">

        <div class="mb-4">
            <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Sales</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-orange-50 {{ request()->routeIs('admin.orders.*') ? 'bg-orange-200 text-orange-600' : '' }}">
                        <span class="text-sm font-medium">Orders</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
