@extends('layout.public')

@section('title', 'Categories')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Categories</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-300">Browse all product categories to quickly find what you're looking
            for.</p>

        <form action="{{ route('categories.index') }}" method="GET" class="mt-4">
            <div class="flex gap-2 max-w-md">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search categories..."
                    class="flex-1 px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <button type="submit"
                    class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">
                    Search
                </button>
                @if ($search ?? false)
                    <a href="{{ route('categories.index') }}"
                        class="px-6 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 font-medium">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if ($categories->isEmpty())
        <div class="py-12 text-center text-gray-500 dark:text-gray-400">No categories found.</div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="group flex items-center gap-3 px-4 py-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 hover:shadow-md transition-all duration-300">

                    <!-- Icon Image -->
                    <div
                        class="shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=100&background=FFF0E5&color=ea580c&bold=true"
                            alt="{{ $category->name }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Category Name -->
                    <span
                        class="flex-1 text-sm font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-300">
                        {{ $category->name }}
                    </span>

                    <!-- Arrow Icon -->
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    @endif

@endsection
