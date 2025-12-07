<footer class="mt-12 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div id="site-contact"
        class="max-w-6xl my-4 mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Brand / About -->
        <div>
            <a href="{{ route('home') }}"
                class="inline-block text-2xl font-semibold text-orange-600 dark:text-orange-500">Kartly</a>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">add to cart on kartly as desc</p>

        </div>

        <!-- Shop -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">Shop</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('categories.index') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Categories</a></li>
                <li><a href="{{ route('products.index') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Shop</a></li>
                <li><a href="{{ route('search.index') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Search</a></li>
                <li><a href="{{ route('cart.index') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Cart</a></li>
                <li><a href="{{ route('coupons.index') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Coupons & Deals</a></li>
            </ul>
        </div>

        <!-- Company -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">Company</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-orange-600 dark:hover:text-orange-400">Home</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-orange-600 dark:hover:text-orange-400">About</a>
                </li>
                <li><a href="{{ route('contact') }}"
                        class="hover:text-orange-600 dark:hover:text-orange-400">Contact</a></li>
                <li><a href="{{ route('status') }}" class="hover:text-orange-600 dark:hover:text-orange-400">Status</a>
                </li>
            </ul>
        </div>
    </div>


</footer>
