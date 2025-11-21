@extends('layout.public')

@section('title', 'Home - Shop Our Products')

@section('content')

    <section class=" my-8">
        <!-- Container to match Navbar alignment -->
        <div class=" mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 h-auto md:h-[400px]">

                <!-- LEFT: Categories Sidebar -->
                <div
                    class="col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="p-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="flex items-center gap-2 text-lg font-bold text-gray-800">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Categories
                        </h2>
                    </div>

                    <div class="flex-1 overflow-y-auto p-2 custom-scrollbar">
                        @if (isset($categories) && $categories->count() > 0)
                            <ul class="space-y-1">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('categories.show', $category->slug ?? '#') }}"
                                            class="group flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-all duration-200
                                        {{ request()->routeIs('categories.show') && request()->slug == $category->slug
                                            ? 'bg-orange-50 text-orange-700 font-semibold'
                                            : 'text-gray-600 hover:bg-gray-50 hover:text-orange-600 hover:translate-x-1' }}">

                                            <span class="flex items-center gap-2">
                                                <!-- Optional: If you have icons for categories, put them here -->
                                                {{ $category->name }}
                                            </span>

                                            <!-- Small arrow icon on hover -->
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-orange-400 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach

                                <!-- View All Link -->
                                <li>
                                    <a href="{{ route('categories.index') }}"
                                        class="flex items-center justify-center mt-2 px-3 py-2 text-xs font-medium text-gray-500 hover:text-orange-600 border-t border-gray-100">
                                        View All Categories
                                    </a>
                                </li>
                            </ul>
                        @else
                            <div class="p-4 text-sm text-gray-400 text-center">No categories found.</div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT: Hero Banner -->
                <div
                    class="col-span-1 md:col-span-3 relative rounded-xl overflow-hidden shadow-md group h-[300px] md:h-full">
                    <!-- Background Image -->
                    <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        src="https://i.ibb.co/vCyRmg2t/image.png" alt="New Collection">

                    <!-- Gradient Overlay (Makes text readable) -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-center px-8 md:px-12">
                        <span
                            class="inline-block px-3 py-1 mb-4 text-xs font-bold tracking-wider text-orange-500 uppercase bg-white/10 backdrop-blur-sm rounded-full w-fit border border-white/20">
                            New Arrival
                        </span>
                        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
                            Exclusive <br /> <span class="text-orange-400">Summer</span> Collection
                        </h1>
                        <p class="text-gray-200 text-sm md:text-lg mb-8 max-w-md">
                            Discover the latest trends with our modern collection. Get up to 50% off on selected items.
                        </p>

                        <div class="flex gap-4">
                            <a href="{{ route('search.index') }}"
                                class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow-lg transition-all transform hover:-translate-y-0.5">
                                Shop Now
                            </a>
                            <a href="{{ route('categories.index') }}"
                                class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg border border-white/30 backdrop-blur-sm transition-all">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    @if (isset($categories) && $categories->count() > 0)
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Section Header -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Shop by Category</h2>
                    <a href="{{ route('categories.index') }}"
                        class="text-sm font-medium text-orange-600 hover:text-orange-700 flex items-center gap-1 transition-colors">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group flex flex-col items-center text-center">

                            <!-- Image Container -->
                            <div class="relative w-28 h-28 mb-4">
                                <!-- Ring Effect Wrapper -->
                                <div
                                    class="absolute inset-0 rounded-full ring-2 ring-gray-100 group-hover:ring-orange-500 group-hover:ring-offset-2 transition-all duration-300 ease-in-out">
                                </div>

                                <!-- Image/Avatar -->
                                <div class="w-full h-full rounded-full overflow-hidden bg-gray-50">
                                    <!-- Note: Changed bg color to orange (f97316) to match theme -->
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=200&background=FFF0E5&color=ea580c&bold=true"
                                        alt="{{ $category->name }}"
                                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500 ease-out">
                                </div>
                            </div>

                            <!-- Text Content -->
                            <h3
                                class="text-base font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-300 px-2">
                                {{ $category->name }}
                            </h3>


                        </a>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    <section>
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Featured Products</h2>

        @if ($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
                @foreach ($products as $product)
                    <x-ui.cards.product-card :product="$product" />
                @endforeach
            </div>

            <div class="flex justify-center mt-8">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <p class="text-gray-600">No products available at the moment.</p>
            </div>
        @endif
    </section>
@endsection
