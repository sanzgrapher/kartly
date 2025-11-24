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

<body class="min-h-screen bg-gray-100 text-gray-800">
    <div class="flex relative">
        @include('layout.partials.admin-sidebar')

        <div class="flex-1 min-h-screen flex flex-col w-full lg:w-auto">
            @include('layout.partials.admin-topbar')

            <main class="p-4 sm:p-6 flex-1">
                <div class="container mx-auto">
                    <h1 class="text-xl sm:text-2xl font-semibold mb-4 hidden lg:block">@yield('title')</h1>
                    @yield('content')
                </div>
            </main>

            <footer class="mt-auto bg-white border-t border-gray-200">
                <div class="container mx-auto px-4 sm:px-6 py-4 text-xs sm:text-sm text-gray-600">
                   {{ config('app.name', 'Kartly') }}
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Toggle sidebar on button click
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }

            // Close sidebar on close button click
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on backdrop
            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on a link (mobile only)
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>

</html>
