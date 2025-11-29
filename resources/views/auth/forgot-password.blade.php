@extends('layout.public')

@section('title', 'Forgot Password')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow px-6 py-8">
        <h2 class="text-2xl font-semibold text-orange-600 mb-2">Reset Password</h2>
        <p class="text-sm text-gray-600 mb-6">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-300">
                @error('email')
                    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
                    Email Password Reset Link
                </button>
            </div>
        </form>

        <div class="mt-6 text-sm text-center text-gray-600">
            Remember your password?
            <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Back to Login</a>
        </div>
    </div>
@endsection
