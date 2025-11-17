@extends('layout.public')

@section('title', 'Log in')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h2 class="text-2xl font-semibold text-orange-600 mb-2">Log in to {{ config('app.name', 'Kartly') }}</h2>
    <p class="text-sm text-gray-500 mb-6">Welcome back</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
            @error('email')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm text-gray-700">Password</label>
            <input id="password" type="password" name="password" required class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
            @error('password')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center text-sm text-gray-700">
                <input type="checkbox" name="remember" class="mr-2"> Remember me
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-600 hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Log in</button>
        </div>
    </form>

    <div class="mt-6 text-sm text-center text-gray-600">
        Don't have an account?
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="text-orange-600 hover:underline">Register Now</a>
        @endif
    </div>
</div>
@endsection
