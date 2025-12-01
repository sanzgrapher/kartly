@extends('layout.public')

@section('title', 'Contact')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded overflow-hidden shadow-sm">
        <div class="p-6">
            <h1 class="text-2xl sm:text-3xl font-semibold dark:text-white mb-4">Contact {{ config('app.name', 'Kartly') }}
            </h1>
        </div>

        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800">
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-100 rounded text-green-800">{{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-100 rounded text-red-800">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 max-w-2xl">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900"
                                placeholder="Your name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900"
                                placeholder="you@example.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea name="message" rows="6"
                            class="mt-1 block w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200 dark:focus:ring-orange-900"
                            placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-md">Send message</button>
                    </div>
                </form>
            </div>

            <aside class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded">
                <p class="text-sm text-gray-700 dark:text-gray-300">Fill out the form and we will reply back soon.</p>
            </aside>
        </div>
    </div>
@endsection
