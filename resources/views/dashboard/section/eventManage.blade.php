<div x-show="activeTab === 'events'" 
     x-data="{
        searchQuery: '',
        filterEvents(event) {
            return this.searchQuery === '' || 
                event.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                event.description.toLowerCase().includes(this.searchQuery.toLowerCase());
        },
        resetFilters() {
            this.searchQuery = '';
        }
     }"
     x-init="() => {
        // Restore active tab from session storage
        let savedTab = sessionStorage.getItem('activeTab');
        if (savedTab) {
            activeTab = savedTab;
        }

        // Watch for tab changes and save to session storage
        $watch('activeTab', (value) => {
            sessionStorage.setItem('activeTab', value);
        });
    }"
     x-transition:enter="transition-all ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="grid grid-cols-1 gap-6">

    <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden">
        <div class="p-6 border-b border-slate-800/80 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Event Management</h2>
            <a href="{{route('event.create')}}"
                    class="px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-400 hover:to-emerald-400 transition-all duration-300 transform hover:-translate-y-0.5">
                Create Event
            </a>
        </div>

        <!-- Search Section -->
        <div class="p-4 border-b border-slate-800/80">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Search events..."
                                   class="w-full sm:w-64 pl-10 pr-4 py-2 bg-slate-950/50 backdrop-blur-sm border border-slate-800/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500/50 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>
                </div>
                <div class="flex items-end">
                    <button @click="resetFilters"
                        class="px-6 py-3 bg-slate-700/50 text-white rounded-xl hover:bg-slate-600/50 transition-all duration-300">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @if(auth()->user()->role === 'admin')
                @foreach($events as $event)
                <div x-show="filterEvents($el.querySelector('[x-ref=eventData]').dataset)"
                     x-transition
                     class="bg-slate-800/50 rounded-xl overflow-hidden border border-slate-700/50 hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1">
                    <div x-ref="eventData" 
                         data-name="{{ $event->name }}"
                         data-description="{{ $event->description }}"
                         class="hidden"></div>
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="object-cover w-full h-full">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-white truncate">{{ $event->name }}</h3>
                        <p class="text-sm text-slate-400 line-clamp-2 h-10 mb-3">{{ $event->description }}</p>

                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-slate-300 bg-slate-700/50 px-2 py-1 rounded">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('event.queue', $event->id) }}"
                                class="text-xs px-3 py-1.5 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500/30 transition-colors">
                                <i class="fas fa-users mr-1"></i> Queue
                            </a>
                            <a href="{{ route('event.edit', $event->id) }}"
                                class="text-xs px-3 py-1.5 bg-teal-500/20 text-teal-400 rounded hover:bg-teal-500/30 transition-colors">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline delete-event-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs px-3 py-1.5 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($myEvents as $event)
                <div x-show="filterEvents($el.querySelector('[x-ref=eventData]').dataset)"
                     x-transition
                     class="bg-slate-800/50 rounded-xl overflow-hidden border border-slate-700/50 hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1">
                    <div x-ref="eventData" 
                         data-name="{{ $event->name }}"
                         data-description="{{ $event->description }}"
                         class="hidden"></div>
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="object-cover w-full h-full">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-white truncate">{{ $event->name }}</h3>
                        <p class="text-sm text-slate-400 line-clamp-2 h-10 mb-3">{{ $event->description }}</p>

                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs text-slate-300 bg-slate-700/50 px-2 py-1 rounded">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('event.queue', $event->id) }}"
                                class="text-xs px-3 py-1.5 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500/30 transition-colors">

                                <i class="fas fa-users mr-1"></i> Queue
                            </a>
                            <a href="{{ route('event.edit', $event->id) }}"
                                class="text-xs px-3 py-1.5 bg-teal-500/20 text-teal-400 rounded hover:bg-teal-500/30 transition-colors">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline delete-event-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs px-3 py-1.5 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>



