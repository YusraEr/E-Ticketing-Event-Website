@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950" 
    x-data="{...userDashboard(), activeTab: '{{ request()->section ?? 'bookings' }}'}" x-cloak>
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-96 h-96 -top-48 -left-48 bg-teal-500/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute w-96 h-96 -bottom-48 -right-48 bg-emerald-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute w-96 h-96 top-1/2 left-1/2 bg-cyan-500/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Main Content -->
    <div class="relative py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Bookings -->
                <div class="stats-card" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $bookings->count() }}, 100)">
                    <div class="relative p-6 bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden group hover:border-teal-500/50 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-500/10 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex justify-between items-center">
                            <div>
                                <p class="text-sm text-slate-400 mb-1">Total Bookings</p>
                                <h3 class="text-3xl font-bold text-white" x-text="count">0</h3>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                        </div>
                        {{-- <div class="mt-4 flex items-center text-sm">
                            <span class="text-teal-400">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                +12.5
                            </span>
                            <span class="text-slate-400 ml-2">from last month</span>
                        </div> --}}
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="stats-card" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $bookings->sum('total_amount') }}, 100)">
                    <div class="relative p-6 bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden group hover:border-teal-500/50 transition-all duration-300">
                        <div class="relative flex justify-between items-center">
                            <div>
                                <p class="text-sm text-slate-400 mb-1">Total Spent</p>
                                <h3 class="text-3xl font-bold text-white">Rp <span x-text="count.toLocaleString('id-ID')">0</span></h3>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Favorites -->
                <div class="stats-card" x-data="{ count: 0 }" x-init="setTimeout(() => count = {{ $favorites->count() }}, 100)">
                    <div class="relative p-6 bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden group hover:border-teal-500/50 transition-all duration-300">
                        <div class="relative flex justify-between items-center">
                            <div>
                                <p class="text-sm text-slate-400 mb-1">Favorite Events</p>
                                <h3 class="text-3xl font-bold text-white" x-text="count">0</h3>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Tab Navigation -->
            <div class="mb-8 bg-slate-900/80 backdrop-blur-sm rounded-2xl p-2 border border-slate-800/80">
                <nav class="flex space-x-4">
                    <button @click="activeTab = 'bookings'"
                            :class="{ 'bg-gradient-to-r from-teal-500 to-emerald-500 text-white': activeTab === 'bookings' }"
                            class="flex items-center px-6 py-3 text-sm font-medium rounded-lg text-gray-300 hover:text-white transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Booking History
                    </button>
                    <button @click="activeTab = 'favorites'"
                            :class="{ 'bg-gradient-to-r from-teal-500 to-emerald-500 text-white': activeTab === 'favorites' }"
                            class="flex items-center px-6 py-3 text-sm font-medium rounded-lg text-gray-300 hover:text-white transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Favorite Events
                    </button>
                </nav>
            </div>

            <!-- Enhanced Booking History Section -->
            <div x-show="activeTab === 'bookings'"
                 x-transition:enter="transition-all ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-8">
                @include('dashboard.section.booking')
            </div>

            <!-- Enhanced Favorites Section -->
            <div x-show="activeTab === 'favorites'"
                 x-transition:enter="transition-all ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6">
                @include('dashboard.section.favorite')
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('style/dashboard/user.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/dashboard/user.js') }}" defer></script>
@endpush



