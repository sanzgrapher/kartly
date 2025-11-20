@extends('layout.public')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white rounded-r-lg border border-l-0 border-gray-200 p-6">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600">Manage your account and orders</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-linear-to-br from-orange-50 to-orange-100 border border-orange-200 p-6 rounded-lg">
                        <h3 class="text-gray-600 text-sm font-medium mb-2">Total Orders</h3>
                        <p class="text-3xl font-bold text-orange-600">{{ $totalOrders }}</p>
                    </div>
                    <div class="bg-linear-to-br from-blue-50 to-blue-100 border border-blue-200 p-6 rounded-lg">
                        <h3 class="text-gray-600 text-sm font-medium mb-2">Total Spent</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            Rs {{ $totalSpent }}</p>
                    </div>
                    {{-- <div class="bg-linear-to-br from-green-50 to-green-100 border border-green-200 p-6 rounded-lg">
                        <h3 class="text-gray-600 text-sm font-medium mb-2">Active Cart</h3>
                        <p class="text-3xl font-bold text-green-600">{{ Auth::user()->cart?->items?->count() ?? 0 }}</p>
                    </div> --}}
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Account Details</h2>
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Personal
                                    Information</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium text-gray-700">Name:</span> {{ $user->name }}</p>
                                    <p><span class="font-medium text-gray-700">Email:</span> {{ $user->email }}</p>
                                    <p><span class="font-medium text-gray-700">Member Since:</span>
                                        {{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Addres
                                </h3>
                                @if ($user->addresses->isNotEmpty())
                                    @php $address = $user->addresses->first(); @endphp
                                    <address class="not-italic text-gray-600">
                                        {{ $address->street_address_1 }}<br>
                                        @if ($address->street_address_2)
                                            {{ $address->street_address_2 }}<br>
                                        @endif
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ $address->country }}
                                    </address>
                                @else
                                    <p class="text-gray-500 italic">No address saved.</p>
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
