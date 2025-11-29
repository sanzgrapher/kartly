@extends('layout.public')

@section('title', 'Email Verification')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow px-6 py-8">
        <h2 class="text-2xl font-semibold text-orange-600 mb-2">Verify Your Email</h2>
        <p class="text-sm text-gray-600 mb-6">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we
            just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 text-sm">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm">
                    Log Out
                </button>
            </form>
        </div>
    </div>
@endsection
