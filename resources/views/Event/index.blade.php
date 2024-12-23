@extends('layouts.app')

@section('content')
    <!-- Hero Banner Carousel -->
    <div
        class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-teal-900 to-slate-900 h-[calc(100vw*9/16)] max-h-[calc(1920px*9/16)]">
        <div class="swiper-container hero-swiper h-full">
            <div class="swiper-wrapper">
                @foreach ($events as $featured)
                    <div class="swiper-slide relative h-full">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                        <img src="{{ asset('storage/' . $featured->image) }}" class="w-full h-full object-cover"
                            alt="{{ $featured->name }}">
                        <div class="absolute bottom-0 left-0 right-0 p-8 z-20 text-white">
                            <h2
                                class="text-4xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                                {{ $featured->name }}</h2>
                            <p class="text-xl mb-4 text-gray-200">{{ $featured->description }}</p>
                            <a href="{{ route('event.show', $featured->id) }}"
                                class="inline-block bg-gradient-to-r from-teal-500 to-emerald-500 text-white px-6 py-3 rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/50">
                                Get Tickets
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 bg-gradient-to-b from-slate-900 to-slate-800 min-h-screen">
        <!-- Quick Category Links -->
        <div class="flex gap-4 mb-8 overflow-x-auto pb-8 category-scroll">
            <button type="button" data-category=""
                class="flex-shrink-0 px-6 py-2 rounded-full transition-all duration-300 shadow-lg hover:shadow-teal-500/20">
                All
            </button>
            @foreach ($categories as $category)
                <button type="button" data-category="{{ $category->id }}"
                    class="flex-shrink-0 px-6 py-2 rounded-full transition-all duration-300 shadow-lg hover:shadow-teal-500/20">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Top Events Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                Top Events This Week
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="topEventsGrid">
                @foreach ($events as $key => $event)
                    <div
                        class="event-card {{ $key >= 6 ? 'hidden' : '' }} bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-teal-500/20 transition-all duration-300 overflow-hidden border border-slate-700/50 group">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $event->image) }}"
                                class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500"
                                alt="{{ $event->name }}">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                            </div>
                            @if ($event->is_featured)
                                <div
                                    class="absolute top-2 right-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-3 py-1 rounded-full text-sm">
                                    Featured</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-teal-400 text-lg mb-2">{{ $event->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $event->short_description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <span
                                        class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                                    <span class="text-gray-400 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l-1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $event->favorites->count() }}
                                    </span>
                                </div>
                                <a href="{{ route('event.show', $event->id) }}"
                                    class="text-teal-400 hover:text-teal-300 transition-colors duration-300">
                                    Learn More →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($events->count() > 6)
                <div class="text-center mt-6">
                    <button id="showMoreEvents"
                        class="inline-block bg-gradient-to-r from-teal-500 to-emerald-500 text-white px-6 py-3 rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/50">
                        Show More
                    </button>
                </div>
            @endif
        </section>

        <!-- Popular Events -->
        <section class="mb-12 relative">
            <h2 class="text-2xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                Popular Events</h2>
            <div class="max-w-7xl mx-auto overflow-hidden">
                <div class="swiper-container popular-events">
                    <div class="swiper-wrapper">
                        @foreach ($events as $event)
                            <div class="swiper-slide">
                                <a href="{{ route('event.show', $event->id) }}" class="block">
                                    <div
                                        class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-teal-500/20 transition-all duration-300 overflow-hidden border border-slate-700/50 group">
                                        <div class="relative overflow-hidden">
                                            <img src="{{ asset('storage/' . $event->image) }}"
                                                class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500"
                                                alt="{{ $event->name }}">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            </div>
                                        </div>
                                        <div class="p-5">
                                            <h3 class="font-semibold text-teal-400 text-lg mb-2">{{ $event->name }}</h3>
                                            <div class="flex items-center text-sm text-gray-400 space-x-4">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-teal-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                                    </svg>
                                                    <span>{{ $event->bookings->count() ?? 0 }} </span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-rose-500" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l-1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span>{{ $event->favorites->count() ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev text-teal-400 hidden md:flex"></div>
                    <div class="swiper-button-next text-teal-400 hidden md:flex"></div>
                </div>
            </div>
        </section>

        <!-- Search Bar -->
        <div class="mb-6">
            <form id="searchForm" class="flex gap-4">
                <input type="text"
                       name="search"
                       id="searchInput"
                       placeholder="Search events..."
                       value="{{ request('search') }}"
                       class="flex-1 px-4 py-3 rounded-lg bg-slate-800/50 border border-slate-700/50 text-white
                              placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <button type="submit"
                        class="px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white
                               hover:from-teal-600 hover:to-emerald-600 transition-all duration-300">
                    Search
                </button>
            </form>
        </div>

        <!-- Enhanced Filters Section -->
        <div class="bg-slate-800/50 backdrop-blur-sm p-6 rounded-xl shadow-lg border border-slate-700/50 mb-8 mt-12">
            <h2 class="text-xl font-semibold mb-4 text-teal-400">Find Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <select class="filter-select bg-slate-700 border-slate-600 text-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        id="category-filter">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select class="filter-select bg-slate-700 border-slate-600 text-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        id="location-filter">
                    <option value="">All Locations</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->location }}">{{ $event->location }}</option>
                    @endforeach
                </select>
                <input type="date"
                    class="bg-slate-700 border-slate-600 text-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    id="date-filter">
                <select class="filter-select bg-slate-700 border-slate-600 text-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                        id="sort-by">
                    <option value="date-asc">Date (Ascending)</option>
                    <option value="date-desc">Date (Descending)</option>
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                </select>
            </div>
        </div>

        <!-- Main Events Grid -->
        <div id="main-events-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div
                    class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden group hover:shadow-teal-500/20 transition-all duration-300 transform hover:-translate-y-1 h-[400px] flex flex-col">
                    <div class="relative overflow-hidden h-48 flex-shrink-0">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                        </div>
                        <span
                            class="absolute top-2 left-2 px-2 py-1 bg-slate-900/70 backdrop-blur-sm text-teal-400 rounded-lg text-xs font-medium border border-teal-500/20">
                            {{ $event->category ? $event->category->name : 'No Category' }}
                        </span>
                        @if ($event->is_featured)
                            <span
                                class="absolute top-2 right-2 px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-full text-xs font-semibold">
                                Featured
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <h3
                            class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-3 truncate">
                            {{ $event->name }}
                        </h3>

                        <div class="space-y-2 mb-4 flex-grow">
                            <p class="text-sm text-gray-400 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span
                                    class="truncate">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y - h:ia') }}</span>
                            </p>
                            <p class="text-sm text-gray-400 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="truncate">{{ $event->location }}</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center space-x-4 text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                    <span class="text-xs">{{ $event->bookings->count() ?? 0 }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l-1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs">{{ $event->favorites->count() ?? 0 }}</span>
                                </div>
                            </div>
                            <a href="{{ route('event.show', $event->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform group-hover:scale-[1.02] shadow-lg hover:shadow-teal-500/50">
                                <span>Details</span>
                                <svg class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>

    <!-- Sticky Create Button for Admin/Organizer -->
    @if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'organizer'))
        <div class="fixed bottom-8 right-8 z-50">
            <a href="{{ route('event.create') }}"
                class="group flex items-center justify-center w-14 h-14 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full shadow-lg hover:shadow-teal-500/50 transition-all duration-300 hover:-translate-y-1">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span
                    class="absolute right-16 bg-slate-900 text-white px-2 py-1 rounded text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Create Event
                </span>
            </a>
        </div>
    @endif
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('style/event/index.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/event/index.js') }}"></script>
@endpush

