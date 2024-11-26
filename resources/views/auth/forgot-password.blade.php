@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md perspective">
        <!-- Enhanced Card Container with Tilt Effect -->
        <div class="bg-slate-800/30 backdrop-blur-md rounded-xl p-8 border border-slate-700/50
            hover:shadow-[0_0_50px_rgba(20,184,166,0.3)] transition-all duration-500 js-tilt"
            data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.2">
            
            <!-- Floating Elements -->
            <div class="absolute -top-8 -right-8 w-16 h-16 bg-teal-500/20 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-emerald-500/20 rounded-full blur-xl animate-pulse delay-700"></div>

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

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6" x-data="{ loading: false }">
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
                    @click="loading = true"
                    :class="{ 'opacity-75 cursor-wait': loading }"
                    class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                    relative overflow-hidden group hover:shadow-[0_0_20px_rgba(20,184,166,0.4)] transition-all duration-500">
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
