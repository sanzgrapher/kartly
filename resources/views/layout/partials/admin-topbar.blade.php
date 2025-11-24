<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 sm:px-6 py-3">
        <div class="flex items-center gap-4">
            <!-- Hamburger menu button for mobile -->
            <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Page title placeholder for mobile -->
            <h1 class="text-lg font-semibold text-gray-800 lg:hidden">@yield('title')</h1>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            @auth
                <span class="text-xs sm:text-sm text-gray-700 hidden sm:inline">Hello, <strong>{{ Auth::user()->name }}</strong></span>
                <span class="text-xs sm:text-sm text-gray-700 sm:hidden"><strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs sm:text-sm text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-xs sm:text-sm text-blue-500 hover:underline">Login</a>
            @endauth
        </div>
    </div>
</header>
