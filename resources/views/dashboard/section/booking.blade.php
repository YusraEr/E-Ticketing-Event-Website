<!-- Advanced Search and Filters -->
<div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-800/80 mb-6">
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1 space-y-4">
            <h3 class="text-lg font-semibold text-white">Search & Filter</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="relative">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" x-model="searchQuery" placeholder="Search bookings..."
                        class="w-full sm:w-64 pl-10 pr-4 py-2 bg-slate-950/50 backdrop-blur-sm border border-slate-800/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500/50 focus:border-transparent transition-all duration-300">
                </div>
                <select x-model="statusFilter"
                    class="w-full sm:w-48 px-4 py-2 bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="ready">Completed</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
        <div class="flex items-end">
            <button @click="resetFilters"
                class="px-6 py-3 bg-slate-700/50 text-white rounded-xl hover:bg-slate-600/50 transition-all duration-300">
                Reset Filters
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Booking Cards Grid -->
<div class="grid gap-6 md:grid-cols-2">
    @forelse($bookings as $booking)
        <div class="booking-card relative group">
            <div
                class="relative bg-slate-900/80 backdrop-blur-sm border border-slate-800/80 rounded-xl overflow-hidden hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1 p-6">
                <!-- Booking Header -->
                <div class="flex justify-between items-start mb-4">
                    <span class="text-sm text-slate-400">#{{ $booking->id }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                    {{ $booking->status === 'ready' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' :
                       ($booking->status === 'pending' ? 'bg-blue-500/10 text-blue-300 border border-blue-500/20' :
                        'bg-red-500/10 text-red-300 border border-red-500/20') }}">
                    {{ ucfirst($booking->status) }}
                </span>
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
                            <svg class="w-5 h-5 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <span>{{ $booking->total_tickets }}
                                {{ Str::plural('Ticket', $booking->total_tickets) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="far fa-money-bill-alt w-5"></i>
                            <span>Total: Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-3 flex justify-end">
                    <a href="{{ route('booking.show', $booking->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-600 to-emerald-600 text-white rounded-lg hover:from-teal-500 hover:to-emerald-500 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-teal-500/30">
                        <span>View Details</span>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div
            class="md:col-span-2 flex flex-col items-center justify-center p-12 bg-slate-900/80 backdrop-blur-sm border border-slate-800/80 rounded-xl">
            <div class="w-48 h-48 mb-4 flex items-center justify-center">
                <i class="fas fa-ticket-alt text-6xl text-gray-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">No Bookings Yet</h3>
            <p class="text-gray-400 text-center mb-4">You haven't made any bookings yet. Start exploring events!</p>
            <a href="{{ route('event.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-600 to-emerald-600 text-white rounded-lg hover:from-teal-500 hover:to-emerald-500 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-teal-500/30">
                Browse Events
            </a>
        </div>
    @endforelse
</div>
