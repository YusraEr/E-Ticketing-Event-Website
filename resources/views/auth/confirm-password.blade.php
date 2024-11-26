@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md perspective">
        <div class="bg-slate-800/30 backdrop-blur-md rounded-xl p-8 border border-slate-700/50
            hover:shadow-[0_0_50px_rgba(20,184,166,0.3)] transition-all duration-500 js-tilt"
            data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-glare data-tilt-max-glare="0.2">
            
            <!-- Floating Elements -->
            // ...existing floating elements...

            <!-- Enhanced Form -->
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6" x-data="{ loading: false }">
                @csrf

                <div class="transform-gpu transition-all duration-300 hover:scale-[1.02]">
                    <label for="password" class="relative block text-sm font-medium text-gray-300 mb-2 pl-4 before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-2 before:h-2 before:bg-teal-500 before:rounded-full">
                        Password
                    </label>
                    <input id="password" type="password" name="password"
                        class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300"
                        required autocomplete="current-password" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    @click="loading = true"
                    :class="{ 'opacity-75 cursor-wait': loading }"
                    class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                    relative overflow-hidden group hover:shadow-[0_0_20px_rgba(20,184,166,0.4)] transition-all duration-500">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                    <span class="relative" x-show="!loading">{{ __('Confirm') }}</span>
                    <span class="relative" x-show="loading">
                        <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
// ...existing tilt initialization...
@endpush
@endsection
