@extends('layout.public')

@section('title', 'About')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded overflow-hidden shadow-sm">
        <div class="p-6">
            <h1 class="text-2xl sm:text-3xl font-semibold dark:text-white mb-4">About {{ config('app.name', 'Kartly') }}</h1>
        </div>

        <div class="p-6">
            <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">This is Kartly, an ecommerce website.</p>
        </div>
    </div>
@endsection
