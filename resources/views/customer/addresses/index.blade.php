@extends('layout.public')

@section('title', 'My Addresses')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white rounded-r-lg border border-l-0 border-gray-200 p-6">
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-semibold mb-2">My Addresses</h1>
                        <p class="text-gray-600">Manage your delivery addresses</p>
                    </div>
                    <a href="{{ route('addresses.create') }}"
                        class="bg-orange-600 text-white px-6 py-2 rounded-md hover:bg-orange-700 transition font-medium">
                        Add New Address
                    </a>
                </div>

                @if ($addresses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($addresses as $address)
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                                <div class="flex justify-between items-start mb-4">
                                     
                                    <div class="flex gap-2">
                                        <a href="{{ route('addresses.edit', $address) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                                        <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this address?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>

                                <p class="text-gray-700 mb-2">{{ $address->street_address }}</p>
                                <p class="text-gray-600">{{ $address->city }}, {{ $address->state }}
                                    {{ $address->postal_code }}</p>
                                <p class="text-gray-600">{{ $address->country }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-12 text-center">
                        <p class="text-gray-600 mb-4">No addresses saved yet.</p>
                        <a href="{{ route('addresses.create') }}"
                            class="bg-orange-600 text-white px-6 py-2 rounded-md hover:bg-orange-700 transition font-medium inline-block">
                            Add Your First Address
                        </a>
                    </div>
                @endif
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
