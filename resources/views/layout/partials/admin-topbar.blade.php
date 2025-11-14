<header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-3">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="text-gray-600 md:hidden">toggle</button>
          
        </div>

        <div class="flex items-center gap-4">
            @auth
                <span class="text-sm text-gray-700">Hello, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-blue-500 hover:underline">Login</a>
            @endauth
        </div>
    </div>
</header>
