@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-900 to-slate-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                Book Your Tickets
            </h1>
            <p class="mt-2 text-gray-400">Complete your booking details below</p>
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden
                            hover:shadow-teal-500/20 transition-all duration-300">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-slate-700/50 bg-gradient-to-r from-slate-800/80 to-slate-900/80">
                        <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                            Select Your Tickets
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Choose the number of tickets you'd like to purchase</p>
                    </div>

                    <!-- Form Section -->
                    <form method="POST" action="{{ route('booking.store') }}" id="booking-form" class="p-6 space-y-8">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ request('event_id') }}">

                        <!-- User Info -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Name</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly
                                    class="w-full bg-slate-900/50 border border-slate-700/50 rounded-lg px-4 py-2.5
                                           text-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly
                                    class="w-full bg-slate-900/50 border border-slate-700/50 rounded-lg px-4 py-2.5
                                           text-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                            </div>
                        </div>

                        <!-- Ticket Selection -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                                Available Tickets
                            </h3>
                            <div class="space-y-4">
                                @foreach($tickets as $ticket)
                                <div class="group border border-slate-700/50 rounded-lg p-4 bg-slate-800/30 backdrop-blur-sm
                                            hover:border-teal-500/50 hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                        <div class="flex-grow">
                                            <h4 class="font-medium text-teal-400">{{ $ticket->name }}</h4>
                                            <p class="text-emerald-400 font-medium" data-price="{{ $ticket->price }}">
                                                Rp {{ number_format($ticket->price, 0, ',', '.')}}
                                            </p>
                                            <p class="text-sm text-gray-400 mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ $ticket->available_tickets }} tickets available
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button"
                                                class="quantity-btn minus w-10 h-10 flex items-center justify-center rounded-lg
                                                       bg-slate-900/50 border border-slate-700/50 text-teal-400
                                                       hover:bg-slate-700/50 hover:border-teal-500/50 transition-all duration-300"
                                                data-ticket-id="{{ $ticket->id }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <input type="number" name="quantities[{{ $ticket->id }}]" value="0" min="0"
                                                   max="{{ $ticket->available_tickets }}" step="1" data-ticket-id="{{ $ticket->id }}"
                                                   class="quantity-input w-16 text-center bg-slate-900/50 border border-slate-700/50 rounded-lg
                                                          text-teal-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                                            <button type="button"
                                                class="quantity-btn plus w-10 h-10 flex items-center justify-center rounded-lg
                                                       bg-slate-900/50 border border-slate-700/50 text-teal-400
                                                       hover:bg-slate-700/50 hover:border-teal-500/50 transition-all duration-300"
                                                data-ticket-id="{{ $ticket->id }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Booking Summary Sidebar -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 sticky top-8
                            hover:shadow-teal-500/20 transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-4">
                            Booking Summary
                        </h3>
                        <div class="space-y-4">
                            <div id="selected-tickets" class="divide-y divide-slate-700/50">
                                <!-- Dynamic content via JS -->
                            </div>

                            <div class="border-t border-slate-700/50 pt-4 mt-4">
                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-slate-700/50">
                                    <span class="text-lg font-semibold text-gray-300">Total</span>
                                    <span id="total-amount" class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                                        Rp. 0.00
                                    </span>
                                </div>
                            </div>

                            <!-- Add this error alert div before the button -->
                            <div id="booking-error" class="hidden">
                                <p class="text-red-500 text-sm text-center mb-4">
                                    Please select at least one ticket to continue
                                </p>
                            </div>

                            <button type="submit" form="booking-form" id="submit-booking"
                                class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500/50 to-emerald-500/50 text-white font-medium
                                       cursor-not-allowed opacity-50 transition-all duration-300"
                                disabled>
                                Complete Booking
                            </button>

                            <p class="text-xs text-gray-400 text-center mt-4">
                                By completing this booking, you agree to our
                                <a href="" class="text-teal-400 hover:text-teal-300 transition-colors duration-200">Terms of Service</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.tickets = @json($tickets);
</script>
<script src="{{ asset('js/booking.js') }}"></script>
@endsection

