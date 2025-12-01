<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30 transition-colors duration-300">
    <div class="flex items-center justify-between px-4 sm:px-6 py-3">
        <div class="flex items-center gap-4">
            <!-- Hamburger menu button for mobile -->
            <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Page title placeholder for mobile -->
            <h1 class="text-lg font-semibold text-gray-800 dark:text-white lg:hidden">@yield('title')</h1>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Dark Mode Toggle -->
            <button @click="toggleTheme()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                <!-- Sun Icon -->
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <!-- Moon Icon -->
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                    </path>
                </svg>
            </button>
            @auth
                <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 hidden sm:inline">Hello, <strong>{{ Auth::user()->name }}</strong></span>
                <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 sm:hidden"><strong>{{ Auth::user()->name }}</strong></span>
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
