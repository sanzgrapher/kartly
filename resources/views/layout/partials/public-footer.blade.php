<footer class="mt-12 bg-white border-t border-gray-200">
    <div id="site-contact"
        class="max-w-6xl my-4 mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Brand / About -->
        <div>
            <a href="{{ route('home') }}" class="inline-block text-2xl font-semibold text-orange-600">Kartly</a>
            <p class="text-sm text-gray-600 mt-3">Draft tagline: Fast, Reliable, and Delightful shopping experiences.
                This is placeholder text for Kartly's short description.</p>


        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Quick Links</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-orange-600">Home</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-orange-600">Shop</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-orange-600">About</a></li>

            </ul>
        </div>

        <!-- Support / Newsletter / Social -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Support & Socials</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('contact') }}" class="hover:text-orange-600">Contact Us</a></li>
                <li><a href="#" class="hover:text-orange-600">Returns & Refunds</a></li>
                <li><a href="#" class="hover:text-orange-600">Shipping Info</a></li>
                <li><a href="#" class="hover:text-orange-600">Terms of Service</a></li>
                <li><a href="#" class="hover:text-orange-600">Privacy Policy</a></li>
            </ul>


        </div>
    </div>


</footer>
