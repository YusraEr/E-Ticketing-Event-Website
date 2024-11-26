@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md perspective">
        <!-- Enhanced Card Container with Tilt Effect -->
        <div class="bg-slate-800/30 backdrop-blur-md rounded-xl p-8 border border-slate-700/50
            hover:shadow-[0_0_50px_rgba(20,184,166,0.3)] transition-all duration-500 js-tilt"
            data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.2">

            <!-- Floating Elements -->
            <div class="absolute -top-8 -right-8 w-16 h-16 bg-teal-500/20 rounded-full blur-xl animate-pulse z-50"></div>
            <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-emerald-500/20 rounded-full blur-xl animate-pulse z-50 delay-700"></div>

            <!-- Enhanced Header -->
            <div class="text-center mb-8 relative">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-20 h-1 bg-gradient-to-r from-transparent via-teal-500 to-transparent z-40"></div>
                <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400
                    [text-shadow:_0_1px_20px_rgb(20_184_166_/_20%)]">
                    Welcome Back
                </h1>
                <p class="text-gray-400 mt-2">Log in to your EventHub account</p>
            </div>

            @if(session('status'))
                <div class="mb-4 p-4 rounded-lg bg-teal-500/10 border border-teal-500/50 text-teal-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ loading: false }">
                @csrf

                <!-- Enhanced Input Fields -->
                <div class="transform-gpu transition-all duration-300 hover:scale-[1.02]">
                    <label for="email" class="relative block text-sm font-medium text-gray-300 mb-2 pl-4 before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-2 before:h-2 before:bg-teal-500 before:rounded-full">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                        placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300
                        hover:bg-slate-800/50 hover:shadow-[0_0_20px_rgba(20,184,166,0.15)]"
                        required autofocus />
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="transform-gpu transition-all duration-300 hover:scale-[1.02]">
                    <label for="password" class="relative block text-sm font-medium text-gray-300 mb-2 pl-4 before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-2 before:h-2 before:bg-teal-500 before:rounded-full">Password</label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                            placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300
                            hover:bg-slate-800/50 hover:shadow-[0_0_20px_rgba(20,184,166,0.15)]"
                            required />
                        <button type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-teal-400 focus:outline-none">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Enhanced Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center group">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-slate-700/50 text-teal-500 focus:ring-teal-500 bg-slate-900/50
                            group-hover:ring-2 group-hover:ring-teal-500/50 transition-all duration-300">
                        <span class="ml-2 text-sm text-gray-400 group-hover:text-teal-400 transition-colors duration-300">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-teal-400 hover:text-teal-300 transition-colors duration-300">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Enhanced Submit Button -->
                <button type="submit"
                    class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                    relative overflow-hidden group hover:shadow-[0_0_20px_rgba(20,184,166,0.4)] transition-all duration-500">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                    <span class="relative inline-flex items-center justify-center" ">
                        Sign In
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </button>

                @if (Route::has('register'))
                    <p class="text-center mt-6 text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-teal-400 hover:text-teal-300 transition-colors duration-300">
                            Register now
                        </a>
                    </p>
                @endif
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

