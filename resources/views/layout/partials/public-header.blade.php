<header class="w-full p-4 mb-6 border-b border-gray-200 bg-white shadow-sm">
    <div class="flex items-center justify-between max-w-6xl mx-auto">
        <div>
            <a href="{{ url('/') }}" class="text-2xl font-semibold text-orange-600">{{ config('app.name', 'Kartly') }}</a>
         </div>
        <nav class="flex items-center gap-4">
            @auth
                <span class="text-sm text-orange-700">Hello, {{ Auth::user()->name }}</span>
                <a href="{{ url('/dashboard') }}" class="inline-block px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm transition">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-block px-4 py-2 bg-orange-700 text-white rounded hover:bg-orange-800 text-sm transition">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-block px-4 py-2 border border-orange-300 text-orange-700 rounded hover:bg-orange-100 text-sm transition">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm transition">Register</a>
                @endif
            @endauth
        </nav>
    </div>
</header>
