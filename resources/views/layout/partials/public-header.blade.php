<header class="w-full p-4 mb-6 border-b border-gray-200 bg-white shadow-sm">
    <div class="flex items-center justify-between max-w-6xl mx-auto">
        <div>
            <a href="{{ url('/') }}"
                class="text-2xl font-semibold text-orange-600">{{ config('app.name', 'Kartly') }}</a>
        </div>
        <nav class="flex items-center gap-4">
            @auth
                <div class="relative">
                    <a href="{{ route('cart.index') }}"
                        class="inline-block px-4 py-2 text-orange-700 hover:bg-orange-100 rounded text-sm transition relative">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Cart
                        @if (Auth::user()->cart && Auth::user()->cart->cartItem()->count() > 0)
                            <span
                                class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ Auth::user()->cart->cartItem()->count() }}
                            </span>
                        @endif
                    </a>
                </div>


                <div class="relative" id="user-menu-container">
                    <button id="user-avatar-btn"
                        class="flex items-center justify-center w-10 h-10 rounded-full overflow-hidden border-2 border-orange-500 hover:border-orange-600 transition cursor-pointer"
                        title="{{ Auth::user()->name }}">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&size=160&background=ef4444&color=fff"
                            alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    </button>


                    <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="{{ url('/dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4v4m4-4v4m4-5V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2z">
                                </path>
                            </svg>
                            Dashboard
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-200">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const avatarBtn = document.getElementById('user-avatar-btn');
                        const userMenu = document.getElementById('user-menu');
                        const menuContainer = document.getElementById('user-menu-container');


                        avatarBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            userMenu.classList.toggle('hidden');
                        });


                        document.addEventListener('click', function(e) {
                            if (!menuContainer.contains(e.target)) {
                                userMenu.classList.add('hidden');
                            }
                        });


                        userMenu.querySelectorAll('a').forEach(link => {
                            link.addEventListener('click', function() {
                                userMenu.classList.add('hidden');
                            });
                        });
                    });
                </script>
            @else
                <a href="{{ route('login') }}"
                    class="inline-block px-4 py-2 border border-orange-300 text-orange-700 rounded hover:bg-orange-100 text-sm transition">Log
                    in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="inline-block px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm transition">Register</a>
                @endif
            @endauth
        </nav>
    </div>
</header>
