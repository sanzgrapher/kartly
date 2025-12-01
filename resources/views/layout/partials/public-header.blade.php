<header
    class="sticky top-0 z-50 w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <span class="text-2xl font-bold text-orange-600 group-hover:text-black-900 transition-colors">
                        Kartly
                    </span>
                </a>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Home</a>
                <a href="{{ route('products.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Shop</a>
                <a href="{{ route('search.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Search</a>
                <a href="{{ route('categories.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Categories</a>
                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">About</a>
                <a href="{{ route('contact') }}"
                    class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center justify-center p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 dark:text-gray-300 dark:hover:text-orange-400 dark:hover:bg-gray-800 rounded-full transition-all group">

                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>

                    @php
                        $cartCount = 0;
                        if (Auth::check()) {
                            $cartCount = Auth::user()->cart?->cartItem()->count() ?? 0;
                        } else {
                            $sessionId = session()->getId();
                            $cartCount =
                                \App\Models\Cart::where('session_id', $sessionId)->first()?->cartItem()->count() ?? 0;
                        }
                    @endphp

                    @if ($cartCount > 0)
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Dark Mode Toggle -->
                <button @click="toggleTheme()" class="p-2 text-gray-600 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors rounded-full hover:bg-orange-50 dark:hover:bg-gray-800 focus:outline-none" aria-label="Toggle Dark Mode">
                    <!-- Sun Icon -->
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <!-- Moon Icon -->
                    <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                @auth
                    <div class="relative ml-2" id="user-menu-container">
                        <button id="user-avatar-btn"
                            class="flex items-center justify-center w-9 h-9 rounded-full ring-2 ring-transparent hover:ring-orange-200 focus:outline-none focus:ring-orange-500 transition"
                            title="{{ Auth::user()->name }}">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&size=160&background=f97316&color=fff&font-size=0.5"
                                alt="{{ Auth::user()->name }}" class="w-full h-full rounded-full object-cover">
                        </button>

                        <div id="user-menu"
                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 hidden transform origin-top-right transition-all z-50">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-t-lg">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="py-1">
                                @if (Auth::user()->role === \App\Enums\UserRole::ADMIN)
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-gray-700 hover:text-orange-700 dark:hover:text-orange-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                            </path>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('customer.dashboard') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-gray-700 hover:text-orange-700 dark:hover:text-orange-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        My Profile
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-orange-600 dark:text-gray-300 dark:hover:text-orange-400 transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Register
                            </a>
                        @endif
                    </div>
                @endauth

                <button id="mobile-menu-btn"
                    class="md:hidden p-2 rounded-md text-gray-600 hover:text-orange-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-orange-400 dark:hover:bg-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">Home</a>
            <a href="{{ route('products.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">Shop</a>
            <a href="{{ route('search.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">Search</a>
            <a href="{{ route('categories.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">Categories</a>
            <a href="{{ route('about') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">About</a>
            <a href="{{ route('contact') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-gray-800">Contact</a>

            @guest
                <div class="border-t border-gray-100 dark:border-gray-800 mt-2 pt-2 flex gap-2 px-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="flex-1 text-center py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">Register</a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const userAvatarBtn = document.getElementById('user-avatar-btn');
        const userMenu = document.getElementById('user-menu');
        const userMenuContainer = document.getElementById('user-menu-container');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (userAvatarBtn) {
            userAvatarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        document.addEventListener('click', function(e) {
            if (userMenuContainer && !userMenuContainer.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
            if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
