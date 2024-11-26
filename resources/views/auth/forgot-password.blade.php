@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-8 border border-slate-700/50 hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-500">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        Forgot Password
                    </h1>
                    <p class="text-gray-400 mt-2">{{ __('Enter your email to receive a password reset link') }}</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-lg bg-teal-500/10 border border-teal-500/50 text-teal-400">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300"
                            required autofocus />
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium hover:from-teal-600 hover:to-emerald-600 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg hover:shadow-teal-500/50">
                        {{ __('Send Reset Link') }}
                    </button>

                    <p class="text-center mt-6 text-gray-400">
                        <a href="{{ route('login') }}" class="text-teal-400 hover:text-teal-300 transition-colors duration-300">
                            Back to login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
