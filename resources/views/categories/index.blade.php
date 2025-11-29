@extends('layout.public')

@section('title', 'Categories')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">Categories</h1>
        <p class="mt-2 text-gray-600">Browse all product categories to quickly find what you're looking for.</p>

        <form action="{{ route('categories.index') }}" method="GET" class="mt-4">
            <div class="flex gap-2 max-w-md">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search categories..."
                    class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-200">
                <button type="submit"
                    class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium">
                    Search
                </button>
                @if ($search ?? false)
                    <a href="{{ route('categories.index') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if ($categories->isEmpty())
        <div class="py-12 text-center text-gray-500">No categories found.</div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="group flex flex-col items-center text-center">
                    <div class="relative w-28 h-28 mb-4">
                        <div
                            class="absolute inset-0 rounded-full ring-2 ring-gray-100 group-hover:ring-orange-500 group-hover:ring-offset-2 transition-all duration-300 ease-in-out">
                        </div>
                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-50">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&size=200&background=FFF0E5&color=ea580c&bold=true"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500 ease-out">
                        </div>
                    </div>

                    <h3
                        class="text-base font-semibold text-gray-900 group-hover:text-orange-600 transition-colors duration-300 px-2">
                        {{ $category->name }}
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">{{ $category->products_count ?? 0 }} products</p>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $categories->links('pagination::tailwind') }}
        </div>
    @endif

@endsection
