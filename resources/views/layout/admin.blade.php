<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Kartly') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100  text-gray-800">
    <div class="flex">
        @include('layout.partials.admin-sidebar')

        <div class="flex-1 min-h-screen flex flex-col">
            @include('layout.partials.admin-topbar')

            <main class="p-6">
                <div class="container mx-auto">
                    <h1 class="text-2xl font-semibold mb-4">@yield('title')</h1>
                    @yield('content')
                </div>
            </main>

            <footer class="mt-auto bg-white border-t border-gray-200">
                <div class="container mx-auto px-6 py-4 text-sm text-gray-600">
                   {{ config('app.name', 'Kartly') }}
                </div>
            </footer>
        </div>
    </div>

</body>

</html>
