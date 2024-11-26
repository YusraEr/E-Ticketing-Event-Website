<div x-show="activeTab === 'events'"
     x-transition:enter="transition-all ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="grid grid-cols-1 gap-6">

    <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden">
        <div class="p-6 border-b border-slate-800/80 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">Event Management</h2>
            <button @click="createEvent()"
                    class="px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-400 hover:to-emerald-400 transition-all duration-300 transform hover:-translate-y-0.5">
                Create Event
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($events as $event)
            <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700/50 hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1">
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden mb-4">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="object-cover">
                </div>
                <h3 class="text-lg font-medium text-white mb-2">{{ $event->name }}</h3>
                <p class="text-sm text-slate-400 mb-4">{{ $event->description }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-300">{{ $event->event_date }}</span>
                    <div class="space-x-2">
                        <button @click="editEvent({{ $event->id }})" class="text-teal-400 hover:text-teal-300">Edit</button>
                        <button @click="deleteEvent({{ $event->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
