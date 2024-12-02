<div x-show="activeTab === 'events'" x-init="() => {
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @foreach($myEvents as $event)
            <div class="bg-slate-800/50 rounded-xl overflow-hidden border border-slate-700/50 hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="object-cover w-full h-full">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-white truncate">{{ $event->name }}</h3>
                    <p class="text-sm text-slate-400 line-clamp-2 h-10 mb-3">{{ $event->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-300 bg-slate-700/50 px-2 py-1 rounded">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        <div class="space-x-2">
                            <a href="{{ route('event.edit', $event->id) }}"
                                class="text-xs px-2 py-1 bg-teal-500/20 text-teal-400 rounded hover:bg-teal-500/30 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline delete-event-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs px-2 py-1 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
