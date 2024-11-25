<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-white">Favorite Events</h2>
    <input type="text" x-model="favoriteSearch" placeholder="Search favorites..."
           class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 w-64">
</div>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 auto-rows-fr">
    @forelse($favorites as $favorite)
    <div class="favorite-card group h-full">
        <div class="bg-slate-900/80 backdrop-blur-sm rounded-xl shadow-lg border border-slate-800/80 overflow-hidden group
             hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1 h-[400px] flex flex-col">
            <div class="relative overflow-hidden h-48 flex-shrink-0">
                <img src="{{ asset('storage/' . $favorite->event->image) }}"
                     alt="{{ $favorite->event->name }}"
                     class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                <span class="absolute top-2 left-2 px-2 py-1 bg-slate-950/90 backdrop-blur-sm text-teal-300 rounded-lg text-xs font-medium border border-teal-500/30">
                    {{ $favorite->event->category ? $favorite->event->category->name : 'No Category' }}
                </span>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 truncate max-w-[70%]">
                        {{$favorite->event->name}}
                    </h3>
                </div>

                <div class="space-y-2 mb-4 flex-grow">
                    <p class="text-sm text-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="truncate">{{ \Carbon\Carbon::parse($favorite->event->event_date)->format('d M Y') }}</span>
                    </p>
                    <p class="text-sm text-gray-400 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">{{$favorite->event->location}}</span>
                    </p>
                </div>

                <div class="flex justify-between items-center mt-auto">
                    <button x-ref="favBtn_{{ $favorite->event->id }}"
                            @click.prevent="toggleFavorite($event, {{ $favorite->event->id }})"
                            class="text-red-500 hover:text-red-300 transform hover:scale-110 transition-all duration-200">
                        <i class="fas fa-heart text-xl"></i>
                    </button>
                    <a href="{{ route('event.show', $favorite->event->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-600 to-emerald-600 text-white rounded-lg hover:from-teal-500 hover:to-emerald-500 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-teal-500/30">
                        <span>View Details</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty

    <div class="sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center p-8 bg-gray-800 rounded-lg">
        <div class="w-48 h-48 mb-4 flex items-center justify-center">
            <i class="fas fa-heart text-6xl text-gray-600"></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">No Favorite Events</h3>
        <p class="text-gray-400 text-center mb-4">Start adding events to your favorites to see them here!</p>
        <a href="{{ route('event.index') }}" class="px-6 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">
            Discover Events
        </a>
    </div>
    @endforelse
</div>


