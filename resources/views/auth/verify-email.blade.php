@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-8 border border-slate-700/50 hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-500">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        Verify Email
                    </h1>
                    <p class="text-gray-400 mt-4">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 rounded-lg bg-teal-500/10 border border-teal-500/50 text-teal-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif

                <div class="flex flex-col space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium hover:from-teal-600 hover:to-emerald-600 transform hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg hover:shadow-teal-500/50">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-slate-700/50 text-white font-medium hover:bg-slate-600/50 transition-all duration-300">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
