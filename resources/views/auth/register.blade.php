@extends('layout.public')

@section('title', 'Create account')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow px-6 py-8">
        <h2 class="text-2xl font-semibold text-orange-600 mb-2">Create an account</h2>
        <p class="text-sm text-gray-500 mb-6">Register on {{ config('app.name', 'Kartly') }}.</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm text-gray-700">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
               
            </div>

            <div>
                <label for="username" class="block text-sm text-gray-700">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
                
            </div>

            <div>
                <label for="email" class="block text-sm text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
               
            </div>

            <div>
                <label for="password" class="block text-sm text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
                
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm text-gray-700">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
            </div>
            @if ($errors->any())
                <div class="text-xs text-red-600 mt-1">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Create account</button>
            </div>
        </form>

        <div class="mt-6 text-sm text-center text-gray-600">
            Already have an account 
            <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Sign in</a>
        </div>
    </div>
@endsection
