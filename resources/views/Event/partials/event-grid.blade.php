@foreach ($events as $event)
    <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden group hover:shadow-teal-500/20 transition-all duration-300 transform hover:-translate-y-1 h-[400px] flex flex-col">
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
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
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
