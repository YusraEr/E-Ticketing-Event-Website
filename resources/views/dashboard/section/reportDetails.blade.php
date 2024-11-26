<div x-show="activeTab === 'reports'"
     x-transition:enter="transition-all ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="grid grid-cols-1 gap-6">

    <!-- Revenue Overview -->
    <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden">
        <div class="p-6 border-b border-slate-800/80">
            <h2 class="text-xl font-semibold text-white">Revenue Overview</h2>
        </div>
        <div class="p-6">
            <canvas id="revenueChart" class="w-full h-72"></canvas>
        </div>
    </div>

    <!-- Event Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 p-6">
            <h3 class="text-lg font-medium text-white mb-4">Popular Events</h3>
            <div class="space-y-4">
                @foreach($events as $event)
                <div class="flex items-center justify-between">
                    <span class="text-slate-300">{{ $event->name }}</span>
                    <span class="text-slate-400">{{ $event->bookings->count() }} attendees</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 p-6">
            <h3 class="text-lg font-medium text-white mb-4">User Growth</h3>
            <canvas id="userGrowthChart" class="w-full h-48"></canvas>
        </div>
    </div>
</div>
