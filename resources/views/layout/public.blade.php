<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name', 'Kartly')) - {{ config('app.name', 'Kartly') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen  bg-[#FDFDFC] text-[#1b1b18] font-sans">
 
    <main class="w-full lg:max-w-6xl max-w-[1120px] mx-auto px-4 pb-16 pt-6">
        @yield('content')
    </main>


</body>

</html>
