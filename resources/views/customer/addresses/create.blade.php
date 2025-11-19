@extends('layout.public')

@section('title', 'Add New Address')

@section('content')
    <div class="container mx-auto flex flex-col min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-0 flex-1">

            <div class="md:col-span-1">
                @include('customer.partials.sidebar')
            </div>


            <div class="md:col-span-3 bg-white rounded-r-lg border border-l-0 border-gray-200 p-6">
                <div class="mb-8">
                    <h1 class="text-3xl font-semibold mb-2">Add New Address</h1>
                    <p class="text-gray-600">Enter your delivery address details</p>
                </div>

                <form action="{{ route('addresses.store') }}" method="POST" class="max-w-2xl">
                    @csrf

                    <div class="mb-6">
                        <label for="street_address_1" class="block text-gray-700 font-medium mb-2">Street Address *</label>
                        <input type="text" id="street_address_1" name="street_address_1"
                            value="{{ old('street_address_1') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                            placeholder="Enter your street address" required>
                        @error('street_address_1')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="street_address_2" class="block text-gray-700 font-medium mb-2">Apartment, Suite, etc.
                            (Optional)</label>
                        <input type="text" id="street_address_2" name="street_address_2"
                            value="{{ old('street_address_2') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                            placeholder="Apartment number, suite, etc.">
                        @error('street_address_2')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="city" class="block text-gray-700 font-medium mb-2">City *</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                placeholder="City" required>
                            @error('city')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-gray-700 font-medium mb-2">State/Province *</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                placeholder="State/Province" required>
                            @error('state')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="country" class="block text-gray-700 font-medium mb-2">Country *</label>
                        <input type="text" id="country" name="country" value="{{ old('country') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                            placeholder="Country" required>
                        @error('country')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-orange-600 text-white px-6 py-2 rounded-md hover:bg-orange-700 transition font-medium">
                            Save Address
                        </button>
                        <a href="{{ route('addresses.index') }}"
                            class="bg-gray-300 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-400 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
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
