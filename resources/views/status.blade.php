@extends('layout.public')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-extrabold text-center mb-8">Service Status</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white">
                            <!-- server icon -->
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="8" rx="2"></rect>
                                <rect x="2" y="13" width="20" height="8" rx="2"></rect>
                                <circle cx="6" cy="7" r="1"></circle>
                                <circle cx="6" cy="17" r="1"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-semibold">Typesense</p>
                        <p class="text-sm text-gray-500">Search server health</p>
                    </div>
                    <div class="text-right">
                        @if ($typesense === true)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Running</span>
                        @elseif($typesense === false)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Not
                                Running</span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Unknown</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    Endpoint: <code class="bg-gray-100 px-2 py-1 rounded">http://localhost:8108/health</code>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="p-3 rounded-full bg-gradient-to-tr from-yellow-400 to-orange-500 text-white">
                            <!-- mail icon -->
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8"></path>
                                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-lg font-semibold">Mailpit</p>
                        <p class="text-sm text-gray-500">Local SMTP/web UI for testing emails</p>
                    </div>
                    <div class="text-right">
                        @if ($mailpit === true)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Running</span>
                        @elseif($mailpit === false)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Not
                                Running</span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Unknown</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    Endpoint: <code class="bg-gray-100 px-2 py-1 rounded">http://localhost:8025/</code>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            Last checked: <span id="status-checked">{{ now()->toDayDateTimeString() }}</span>
        </div>
    </div>
@endsection
