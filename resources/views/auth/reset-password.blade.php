@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-8 border border-slate-700/50 hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-500">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        Reset Password
                    </h1>
                    <p class="text-gray-400 mt-2">Create your new password</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
                        @error('email')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                        <input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               type="password" name="password" required autocomplete="new-password" />
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               type="password" name="password_confirmation" required autocomplete="new-password" />
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium hover:from-teal-600 hover:to-emerald-600 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg hover:shadow-teal-500/50">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
