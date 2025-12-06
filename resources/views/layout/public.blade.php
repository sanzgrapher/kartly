<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name', 'Kartly')) - {{ config('app.name', 'Kartly') }}</title>

    <script>
        // Check local storage and system preference on load to prevent FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
</head>

<body
    class="min-h-screen bg-[#FDFDFC] dark:bg-gray-900 text-[#1b1b18] dark:text-gray-100 font-sans transition-colors duration-300"
    x-data="{
        darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleTheme() {
            this.darkMode = !this.darkMode;
        }
    }" x-init="$watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    })">
    <div class="min-h-screen flex flex-col">
        @include('layout.partials.public-header')

        <main class="flex-1 w-full mt-6 lg:max-w-6xl max-w-[1120px] mx-auto px-4 pb-16">
            @yield('content')
        </main>

        @include('layout.partials.public-footer')
    </div>

    @livewireScripts
</body>

</html>
