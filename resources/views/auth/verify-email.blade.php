@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md perspective">
        <div class="bg-slate-800/30 backdrop-blur-md rounded-xl p-8 border border-slate-700/50
            hover:shadow-[0_0_50px_rgba(20,184,166,0.3)] transition-all duration-500 js-tilt"
            data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.2">

            <!-- Floating Elements -->
            <div class="absolute -top-8 -right-8 w-16 h-16 bg-teal-500/20 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-emerald-500/20 rounded-full blur-xl animate-pulse delay-700"></div>

            <!-- Enhanced Header with Animation -->
            <div class="text-center mb-8 relative transform transition-all duration-500 hover:scale-105">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-20 h-1 bg-gradient-to-r from-transparent via-teal-500 to-transparent"></div>
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
                <form method="POST" action="{{ route('verification.send') }}" x-data="{ loading: false }">
                    @csrf
                    <button type="submit"
                        @click="loading = true"
                        :class="{ 'opacity-75 cursor-wait': loading }"
                        class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                        relative overflow-hidden group hover:shadow-[0_0_20px_rgba(20,184,166,0.4)] transition-all duration-500">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                        <span class="relative" x-show="!loading">{{ __('Resend Verification Email') }}</span>
                        <span class="relative" x-show="loading">
                            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
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

@push('scripts')
<script>
    VanillaTilt.init(document.querySelectorAll(".js-tilt"), {
        max: 5,
        speed: 400,
        glare: true,
        "max-glare": 0.2,
    });
</script>
@endpush
@endsection
