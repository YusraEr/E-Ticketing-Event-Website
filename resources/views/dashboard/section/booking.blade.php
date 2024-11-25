<!-- Advanced Search and Filters -->
<div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-800/80 mb-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 space-y-4">
            <h3 class="text-lg font-semibold text-white">Search & Filter</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="relative">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Search bookings..."
                           class="w-full sm:w-64 pl-10 pr-4 py-2 bg-slate-950/50 backdrop-blur-sm border border-slate-800/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500/50 focus:border-transparent transition-all duration-300">
                </div>
                <select x-model="statusFilter"
                        class="w-full sm:w-48 px-4 py-2 bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="flex items-end">
            <button @click="resetFilters" class="px-6 py-3 bg-slate-700/50 text-white rounded-xl hover:bg-slate-600/50 transition-all duration-300">
                Reset Filters
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Booking Cards Grid -->
<div class="grid gap-6 md:grid-cols-2">
    @forelse($bookings as $booking)
    <div class="booking-card relative group">
        <div class="relative bg-slate-900/80 backdrop-blur-sm border border-slate-800/80 rounded-xl overflow-hidden hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1 p-6">
            <!-- Booking Header -->
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm text-slate-400">#{{ $booking->id }}</span>
                {{-- <span class="px-3 py-1 rounded-full text-xs font-medium
                    {{ $booking->status === 'active' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' :
                       ($booking->status === 'completed' ? 'bg-blue-500/10 text-blue-300 border border-blue-500/20' :
                        'bg-red-500/10 text-red-300 border border-red-500/20') }}">
                    {{ ucfirst($booking->status) }}
                </span> --}}
            </div>

            <!-- Booking Details -->
            <div class="border-t border-gray-700 py-3">
                <h3 class="text-lg font-semibold text-white mb-3">{{ $booking->event->name }}</h3>
                <div class="space-y-2 text-sm text-gray-400">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt w-5"></i>
                        <span>{{ \Carbon\Carbon::parse($booking->event->event_date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-user w-5"></i>
                        <span>{{ $booking->total_tickets }} {{ Str::plural('Ticket', $booking->total_tickets) }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-money-bill-alt w-5"></i>
                        <span>Total: Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-3 flex justify-end">
                <button class="text-sm text-indigo-400 hover:text-indigo-300 flex items-center">
                    <span>View Details</span>
                    <i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="md:col-span-2 flex flex-col items-center justify-center p-12 bg-slate-900/80 backdrop-blur-sm border border-slate-800/80 rounded-xl">
        <div class="w-48 h-48 mb-4 flex items-center justify-center">
            <i class="fas fa-ticket-alt text-6xl text-gray-600"></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">No Bookings Yet</h3>
        <p class="text-gray-400 text-center mb-4">You haven't made any bookings yet. Start exploring events!</p>
        <a href="{{ route('event.index') }}" class="px-6 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">
            Browse Events
        </a>
    </div>
    @endforelse
</div>
