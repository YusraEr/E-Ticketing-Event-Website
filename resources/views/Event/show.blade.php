@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-slate-900 to-slate-800">
        <!-- Hero Section with Enhanced Parallax -->
        <div class="relative h-[70vh] overflow-hidden">
            <!-- Back Button with Glass Effect -->
            <a href="{{ route('event.index') }}"
               class="absolute top-4 left-4 z-40 inline-flex items-center px-4 py-2 rounded-lg
                      bg-white/10 backdrop-blur-md border border-white/20
                      text-white/90 shadow-lg shadow-black/5
                      hover:bg-white/20 hover:border-white/30 hover:scale-105
                      transition-all duration-300 ease-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Events
            </a>

            <!-- Add Favorite Button -->
            @auth
                @if(auth()->user()->role === 'user')
                    <div x-data="{
                        isFavorited: {{ Auth::user()->favorites->contains('event_id', $event->id) ? 'true' : 'false' }},
                        isLoading: false,
                        async toggleFavorite() {
                            if (this.isLoading) return;
                            this.isLoading = true;

                            try {
                                if (this.isFavorited) {
                                    await axios.delete('/favorite/{{ $event->id }}');
                                    this.isFavorited = false;
                                } else {
                                    await axios.post('/favorite', { event_id: {{ $event->id }} });
                                    this.isFavorited = true;
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            } finally {
                                this.isLoading = false;
                            }
                        }
                    }"
                    class="absolute top-4 right-4 z-40">
                        <button @click="toggleFavorite()"
                            :disabled="isLoading"
                            class="inline-flex items-center px-4 py-2 rounded-lg
                                bg-white/10 backdrop-blur-md border border-white/20
                                text-white/90 shadow-lg shadow-black/5
                                hover:bg-white/20 hover:border-white/30 hover:scale-105
                                transition-all duration-300 ease-out
                                disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" :class="{ 'text-red-500 fill-red-500': isFavorited }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span x-text="isFavorited ? 'Remove from Favorites' : 'Add to Favorites'"></span>
                        </button>
                    </div>
                @endif
            @endauth

            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $event->image) }}" class="w-full h-full object-cover transform"
                    alt="{{ $event->name }}">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/30 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-teal-900/30 to-emerald-900/30"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-8 backdrop-blur-sm bg-slate-900/30">
                <div class="max-w-7xl mx-auto">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-500/10 text-teal-400 mb-4">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-4">
                        {{ $event->name }}
                    </h1>
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
                    <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 p-6">
                        <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-4">
                            About This Event
                        </h2>
                        <div class="prose prose-invert prose-teal max-w-none text-gray-300">
                            {{ $event->description }}
                        </div>
                    </div>

                    <!-- Features/Highlights -->
                    <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 p-6">
                        <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-4">
                            Event Highlights
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach (['Feature 1', 'Feature 2', 'Feature 3', 'Feature 4'] as $feature)
                                <div class="bg-slate-700/50 p-4 rounded-lg border border-teal-500/20 hover:border-teal-500/40 transition-all duration-300 group">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-teal-500/20 to-emerald-500/20 flex items-center justify-center group-hover:from-teal-500/30 group-hover:to-emerald-500/30 transition-all duration-300">
                                            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-gray-300">{{ $feature }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column - Ticket Selection -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8">
                        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 p-6">
                            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-4">
                                Select Tickets
                            </h2>

                            @guest
                                <div class="space-y-4">
                                    @foreach($event->ticketTypes as $ticket)
                                        <div class="p-4 rounded-lg bg-slate-700/50 border border-teal-500/20">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="font-semibold text-white">{{ $ticket->name }}</h3>
                                                    <p class="text-sm text-gray-300">
                                                        {{ $ticket->available_tickets }} tickets left
                                                    </p>
                                                </div>
                                                <span class="text-lg font-bold text-teal-400">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                                        <a href="{{ route('login') }}"
                                            class="w-full py-3 px-4 text-center bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/50 inline-block">
                                            Login to Book Tickets
                                        </a>
                                    </div>
                                </div>
                            @else
                                @if(auth()->user()->role === 'user')
                                    <form action="{{ route('booking.index') }}" method="">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <div class="space-y-4">
                                            @foreach($event->ticketTypes as $ticket)
                                                <div class="p-4 rounded-lg bg-slate-700/50 border border-teal-500/20 hover:border-teal-500/40 transition-all duration-300"
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
                                                            <h3 class="font-semibold text-white">{{ $ticket->name }}</h3>
                                                            <p class="text-sm text-gray-300">
                                                                {{ $ticket->available_tickets }} tickets left
                                                            </p>
                                                        </div>
                                                        <span class="text-lg font-bold text-teal-400">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between mt-4">
                                                        <div class="flex items-center space-x-2">
                                                            <button type="button" @click="quantity = Math.max(0, quantity - 1)"
                                                                class="w-8 h-8 rounded-full bg-slate-600/50 border border-teal-500/20 flex items-center justify-center hover:bg-slate-600 hover:border-teal-500/40 transition-all duration-300">
                                                                <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                                </svg>
                                                            </button>
                                                            <input type="number"
                                                                name="tickets[{{ $ticket->id }}]"
                                                                x-model.number="quantity"
                                                                :max="available"
                                                                min="0"
                                                                @change="quantity = Math.min(Math.max(0, quantity), available)"
                                                                class="w-16 text-center bg-slate-600/50 border border-teal-500/20 rounded-lg text-white focus:ring-teal-500 focus:border-teal-500">
                                                            <button type="button" @click="quantity = Math.min(available, quantity + 1)"
                                                                class="w-8 h-8 rounded-full bg-slate-600/50 border border-teal-500/20 flex items-center justify-center hover:bg-slate-600 hover:border-teal-500/40 transition-all duration-300">
                                                                <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="text-right">
                                                            <span x-text="`Rp ${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}`"
                                                                class="font-semibold text-teal-400"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                                                <button type="submit"
                                                    class="w-full py-3 px-4 text-center bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/50">
                                                    Proceed to Checkout
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>

            </div>

            <!-- Similar Events Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-6">
                    Similar Events
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $similarEvents = $event->category->events()
                            ->where('id', '!=', $event->id)
                            ->inRandomOrder()
                            ->limit(3)
                            ->get();
                    @endphp

                    @forelse($similarEvents as $similarEvent)
                        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden group">
                            <div class="aspect-w-16 aspect-h-9 relative overflow-hidden">
                                <img src="{{ asset('storage/' . $similarEvent->image) }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300"
                                    alt="{{ $similarEvent->name }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-semibold text-white mb-2">{{ $similarEvent->name }}</h3>
                                <p class="text-sm text-gray-400 mb-4">
                                    {{ \Carbon\Carbon::parse($similarEvent->event_date)->format('F d, Y') }}
                                </p>
                                <a href="{{ route('event.show', $similarEvent) }}"
                                    class="inline-flex items-center text-sm font-medium text-teal-400 hover:text-teal-300 transition-colors">
                                    Learn more
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-400">
                            No similar events found.
                        </div>
                    @endforelse
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


