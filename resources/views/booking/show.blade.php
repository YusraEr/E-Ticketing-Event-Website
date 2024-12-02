@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-96 h-96 -top-48 -left-48 bg-teal-500/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute w-96 h-96 -bottom-48 -right-48 bg-emerald-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Main Content -->
    <div class="relative py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Booking Summary Card -->
            <div class="mb-8 bg-slate-900/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-800/80">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-white">Booking Details</h1>
                    <span class="px-4 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-sm font-medium">
                        Booking #{{ $booking->id }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Event Details Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-teal-500 mb-4">Event Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                <p class="text-white text-lg font-medium">{{ $booking->event->name }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <p class="text-slate-300">{{ $booking->event->location }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-slate-300">{{ \Carbon\Carbon::parse($booking->event->event_date)->format('D, d M Y H:i') }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-slate-300">{{ $booking->event->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Summary Section -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-teal-500 mb-4">Booking Summary</h3>
                        <div class="space-y-4">
                            <div class="bg-slate-800/50 rounded-xl p-4">
                                <p class="text-slate-400 text-sm mb-1">Total Amount</p>
                                <p class="text-white text-2xl font-bold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-slate-800/50 rounded-xl p-4">
                                <p class="text-slate-400 text-sm mb-1">Total Tickets</p>
                                <p class="text-white text-2xl font-bold">{{ $booking->total_tickets }}</p>
                            </div>
                            <div class="flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-slate-300">Booked on {{ \Carbon\Carbon::parse($booking->created_at)->format('D, d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($booking->tickets as $ticket)
                <div class="relative group ticket-card">
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-2xl blur-sm opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative bg-slate-900/90 backdrop-blur-sm rounded-2xl p-6 border border-slate-800/80 overflow-hidden group-hover:border-teal-500/50 transition-all duration-300">
                        <div class="dashed-line"></div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">{{ $ticket->ticketType->name}}</h3>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ $loop->iteration }}
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Ticket Code:</span>
                                <span class="text-white font-mono">{{ $ticket->ticket_code }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Price:</span>
                                <span class="text-white">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Status:</span>
                                <span class="text-white">{{ $ticket->is_used ? 'Used' : 'Available' }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-800">
                            <button class="w-full py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-sm font-medium hover:opacity-90 transition-opacity duration-300">
                                Download Ticket
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center flex items-center justify-center space-x-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 rounded-lg bg-slate-800 text-white hover:bg-slate-700 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Go To dashboard
                </a>

                @if($booking->created_at->diffInHours(now()) <= 24)
                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-6 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel Booking
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('style/dashboard/user.css') }}">
@endpush
