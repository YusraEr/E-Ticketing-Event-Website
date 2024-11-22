@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h1 class="text-2xl font-bold text-gray-800">Book Event Tickets</h1>
                        <p class="text-sm text-gray-600 mt-1">Please select your desired tickets below</p>
                    </div>

                    <!-- Form Section -->
                    <form method="POST" action="{{ route('booking.store') }}" class="p-6 space-y-8">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ request('event_id') }}">

                        <!-- User Info -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" value="{{ Auth::user()->name }}" readonly
                                    class="mt-1 block w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 px-4 py-2.5 transition">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly
                                    class="mt-1 block w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 px-4 py-2.5 transition">
                            </div>
                        </div>

                        <!-- Ticket Selection -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900">Select Tickets</h3>
                            <div class="space-y-4">
                                @foreach($tickets as $ticket)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-200 hover:bg-blue-50/30 transition-all duration-200">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                        <div class="flex-grow">
                                            <h4 class="font-medium text-gray-900">{{ $ticket->name }}</h4>
                                            <p class="text-blue-600 font-medium">${{ number_format($ticket->price, 2) }}</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    {{ $ticket->available_tickets }} tickets available
                                                </span>
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" class="quantity-btn minus w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            </button>
                                            <input type="number" name="quantities[{{ $ticket->id }}]" value="0" min="0"
                                                max="{{ $ticket->available_tickets }}" step="1"
                                                class="w-16 text-center border border-gray-300 rounded-lg px-2 py-2">
                                            <button type="button" class="quantity-btn plus w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
                        <div class="space-y-4">
                            <div id="selected-tickets" class="divide-y divide-gray-100">
                                <!-- Dynamic content will be inserted here via JS -->
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center mt-2 text-sm text-gray-600">
                                    <span>Processing Fee</span>
                                    <span id="fee">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center mt-4 pt-4 border-t">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-xl font-bold text-blue-600" id="total-amount">$0.00</span>
                                </div>
                            </div>

                            <button type="submit" form="booking-form"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transform transition-all duration-200 hover:scale-[1.02] focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Complete Booking
                            </button>

                            <p class="text-xs text-gray-500 text-center mt-4">
                                By completing this booking, you agree to our
                                <a href="#" class="text-blue-600 hover:underline">Terms of Service</a>
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

