@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Hero Section with Parallax Effect -->
        <div class="relative h-[60vh] overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover transform scale-110"
                    style="filter: brightness(0.7);" alt="{{ $event->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div class="max-w-7xl mx-auto">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-500/10 text-indigo-400 mb-4">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $event->name }}</h1>
                    <div class="flex items-center space-x-4 text-white/80">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $event->category->name }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $event->location }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Event Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- About Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About This Event</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {{ $event->description }}
                        </div>
                    </div>

                    <!-- Features/Highlights -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Event Highlights</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach (['Feature 1', 'Feature 2', 'Feature 3', 'Feature 4'] as $feature)
                                <div class="flex items-center space-x-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column - Ticket Selection -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Select Tickets</h2>
                            <form action="{{ route('booking.index') }}" method="">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="space-y-4">
                                    @foreach($event->ticketTypes as $ticket)
                                        <div class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors"
                                            x-data="{
                                                quantity: 0,
                                                price: {{ $ticket->price }},
                                                available: {{ $ticket->available_tickets }},
                                                get total() {
                                                    return (this.quantity * this.price).toFixed(2);
                                                }
                                            }">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $ticket->name }}</h3>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $ticket->available_tickets }} tickets left
                                                    </p>
                                                </div>
                                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($ticket->price, 2) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between mt-4">
                                                <div class="flex items-center space-x-2">
                                                    <button type="button" @click="quantity = Math.max(0, quantity - 1)"
                                                        class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                        </svg>
                                                    </button>
                                                    <input type="number"
                                                        name="tickets[{{ $ticket->id }}]"
                                                        x-model.number="quantity"
                                                        :max="available"
                                                        min="0"
                                                        @change="quantity = Math.min(Math.max(0, quantity), available)"
                                                        class="w-16 text-center border-gray-200 dark:border-gray-700 rounded-md">
                                                    <button type="button" @click="quantity = Math.min(available, quantity + 1)"
                                                        class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="text-right">
                                                    <span x-text="`$${total}`"
                                                        class="font-semibold text-indigo-600 dark:text-indigo-400"></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                                        <button type="submit"
                                            class="w-full py-3 px-4 text-center bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            Proceed to Checkout
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Similar Events Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Similar Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden group">
                            <div class="aspect-w-16 aspect-h-9 relative overflow-hidden">
                                <img src="https://picsum.photos/400/300?random={{ $i }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                            </div>
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Similar Event {{ $i }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Coming Soon</p>
                                <a href="#"
                                    class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                    Learn more
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Calendar Modal -->
    <div x-data="{ open: false }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="open"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6">
                <!-- Modal content here -->
            </div>
        </div>
    </div>
@endsection
