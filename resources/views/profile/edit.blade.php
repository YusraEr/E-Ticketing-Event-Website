@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-900 to-slate-800">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                    {{ __('Profile Settings') }}
                </h1>
                <p class="mt-4 text-slate-400">Manage your account settings and preferences</p>
            </div>

            <!-- Profile Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Profile Information -->
                <div class="md:col-span-2 bg-slate-800/30 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50
                    hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Side Profile Card -->
                <div class="space-y-8">
                    <!-- User Stats Card -->
                    <div class="bg-slate-800/30 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full flex items-center justify-center mb-4">
                                <span class="text-3xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-200">{{ Auth::user()->name }}</h3>
                            <p class="text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>


                    <!-- Quick Actions -->
                    <div class="bg-slate-800/30 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50">
                        <h3 class="text-lg font-semibold text-slate-200 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('dashboard', ['section' => 'bookings']) }}" class="flex items-center p-3 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition-all duration-300">
                                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                <span class="ml-3 text-slate-300">My Tickets</span>
                            </a>
                            <a href="{{ route('dashboard', ['section' => 'favorites']) }}" class="flex items-center p-3 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition-all duration-300">
                                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="ml-3 text-slate-300">Saved Events</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center p-3 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition-all duration-300">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="ml-3 text-slate-300">{{ __('Log Out') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="md:col-span-2 bg-slate-800/30 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50
                    hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account Section -->
                <div class="md:col-span-1 bg-slate-800/30 backdrop-blur-sm rounded-2xl p-8 border border-red-700/30
                    hover:shadow-red-500/10 hover:shadow-2xl hover:border-red-500/30 transition-all duration-500">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

