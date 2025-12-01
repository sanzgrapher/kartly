@extends('layout.public')

@section('title', 'About')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded overflow-hidden shadow-sm">
        <div class="h-56 md:h-72 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1600&q=80')">
            <div class="h-full bg-black/25 flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-2xl sm:text-3xl font-semibold">About {{ config('app.name', 'Kartly') }}</h1>
                    <p class="mt-2 text-sm sm:text-base">A minimal e-commerce starter built to help you prototype and build
                        fast.</p>
                </div>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <h2 class="text-xl font-semibold dark:text-white">Our mission</h2>
                <p class="text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">At {{ config('app.name', 'Kartly') }}, we believe building
                    e-commerce apps should be straightforward, fast, and pleasant. Our starter project focuses on clarity
                    and modularity so you can customize and scale as needed.</p>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border dark:border-gray-700 rounded">
                        <h3 class="font-semibold dark:text-white">Build fast</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Pre-built components, simple architecture, and minimal
                            dependencies so you can iterate quickly.</p>
                    </div>
                    <div class="p-4 border dark:border-gray-700 rounded">
                        <h3 class="font-semibold dark:text-white">Customize</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Easily swap out components and integrate third-party services
                            or custom business logic.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold dark:text-white">What’s inside</h3>
                    <ul class="mt-3 text-sm text-gray-700 dark:text-gray-300 list-disc list-inside">
                        <li>Products, categories and product pages</li>
                        <li>Cart workflows & a simple checkout flow</li>
                        <li>Admin dashboard for managing products, categories and orders</li>
                    </ul>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold dark:text-white">Our story</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">{{ config('app.name', 'Kartly') }} started with a simple
                        idea: make shopping online feel familiar, fast, and reliable. We curate quality products and work
                        with trusted partners so you can shop with confidence.</p>

                    <h3 class="text-lg font-semibold mt-6 dark:text-white">What we offer</h3>
                    <ul class="mt-3 text-sm text-gray-700 dark:text-gray-300 list-disc list-inside">
                        <li>Carefully selected products across categories to fit everyday needs.</li>
                        <li>Clear pricing, transparent shipping, and easy returns.</li>
                        <li>Dedicated customer support to help before and after purchase.</li>
                    </ul>

                    <h3 class="text-lg font-semibold mt-6 dark:text-white">Shipping & returns</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">We aim to dispatch orders quickly and offer
                        straightforward return options. Exact shipping times and return windows are listed on product pages
                        and within our policies.</p>

                    <h3 class="text-lg font-semibold mt-6 dark:text-white">Our promise to customers</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">We put customers first: secure payments, clear
                        communication, and honest product descriptions. If something goes wrong, our support team will make
                        it right.</p>
                </div>
            </div>

            <aside class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded">
                <h3 class="font-semibold dark:text-white">Team</h3>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">We are a small team dedicated to great product selection and
                    exceptional customer service. Our focus is on delivering value and a reliable experience for shoppers.
                </p>

                <div class="mt-4 grid grid-cols-1 gap-3">
                    <div class="flex items-center gap-3">
                        <img class="w-12 h-12 rounded-full object-cover" src="https://placehold.co/80x80?text=A"
                            alt="Team member">
                        <div>
                            <div class="font-medium dark:text-white">Alex</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Founder</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <img class="w-12 h-12 rounded-full object-cover" src="https://placehold.co/80x80?text=B"
                            alt="Team member">
                        <div>
                            <div class="font-medium dark:text-white">Bianca</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Operations</div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <div class="p-6 border-t dark:border-gray-700">
            <h3 class="text-lg font-semibold dark:text-white">Built with care</h3>
            <p class="text-gray-700 dark:text-gray-300 mt-3">This starter app includes concise, readable code and sensible defaults. Use it as
                a foundation for production apps or iterate for prototypes and demos.</p>
        </div>
    </div>
@endsection
