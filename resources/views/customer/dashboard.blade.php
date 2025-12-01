@extends('layout.public')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white dark:bg-gray-800 rounded-r-lg border border-l-0 border-gray-200 dark:border-gray-700 p-6">
                <!-- Email Verification Success Message -->
                @if (request()->get('verified'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <strong>Email verified successfully!</strong> Your account is now fully activated.
                        </div>
                    </div>
                @endif

                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-2 dark:text-white">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600 dark:text-gray-400">Manage your account and orders</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-linear-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border border-orange-200 dark:border-orange-800 p-6 rounded-lg">
                        <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">Total Orders</h3>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-500">{{ $totalOrders }}</p>
                    </div>
                    <div class="bg-linear-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 p-6 rounded-lg">
                        <h3 class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">Total Spent</h3>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-500">
                            Rs {{ $totalSpent }}</p>
                    </div>
                    {{-- <div class="bg-linear-to-br from-green-50 to-green-100 border border-green-200 p-6 rounded-lg">
                        <h3 class="text-gray-600 text-sm font-medium mb-2">Active Cart</h3>
                        <p class="text-3xl font-bold text-green-600">{{ Auth::user()->cart?->items?->count() ?? 0 }}</p>
                    </div> --}}
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4 dark:text-white">Account Details</h2>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Personal
                                    Information</h3>
                                <div class="space-y-2 dark:text-gray-300">
                                    <p><span class="font-medium text-gray-700 dark:text-gray-200">Name:</span> {{ $user->name }}</p>
                                    <p><span class="font-medium text-gray-700 dark:text-gray-200">Email:</span> {{ $user->email }}</p>
                                    <p><span class="font-medium text-gray-700 dark:text-gray-200">Member Since:</span>
                                        {{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Addres
                                </h3>
                                @if ($user->addresses->isNotEmpty())
                                    @php $address = $user->addresses->first(); @endphp
                                    <address class="not-italic text-gray-600 dark:text-gray-300">
                                        {{ $address->street_address_1 }}<br>
                                        @if ($address->street_address_2)
                                            {{ $address->street_address_2 }}<br>
                                        @endif
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ $address->country }}
                                    </address>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 italic">No address saved.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-6 flex justify-end mb-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>
@endsection
