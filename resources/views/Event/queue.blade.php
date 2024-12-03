@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-slate-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-400">
                <li class="flex items-center">
                    <a href="{{ route('event.index') }}" class="hover:text-teal-400 transition-colors">Events</a>
                    <svg class="h-5 w-5 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                    </svg>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('event.show', $event->id) }}" class="hover:text-teal-400 transition-colors">{{ $event->name }}</a>
                    <svg class="h-5 w-5 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
                    </svg>
                </li>
                <li class="text-gray-500">Queue Management</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        Ticket Queue Management
                    </h1>
                    <p class="mt-2 text-gray-400">Manage ticket requests for {{ $event->name }}</p>
                </div>

                @if($queuesByStatus['pending']->isNotEmpty())
                <form action="{{ route('queue.approve.all', $event->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Are you sure you want to approve all pending tickets?')"
                            class="px-6 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white
                                    hover:from-teal-600 hover:to-emerald-600 transition-all duration-300
                                    hover:shadow-lg hover:shadow-teal-500/30 font-medium">
                        Approve All Pending
                    </button>
                </form>
                @endif
            </div>

            <!-- Available Tickets Info -->
            <div class="mt-4 flex flex-wrap gap-4">us
                @foreach($event->ticketTypes as $type)
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-lg px-4 py-2 border border-slate-700/50">
                    <span class="text-sm font-medium text-slate-400">{{ $type->name }}:</span>
                    <div class="flex flex-col">
                        <span class="text-teal-400 font-bold">{{ $type->available_tickets }} available</span>
                    </div>
                </div>
                @endforeach

                <!-- Total Tickets Sold -->
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-lg px-4 py-2 border border-slate-700/50">
                    <span class="text-sm font-medium text-slate-400">Total Tickets Sold:</span>
                    <div class="text-emerald-400 font-bold">
                        {{ $event->bookings->sum('total_tickets')}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @foreach(['pending' => ['yellow', 'clock'], 'ready' => ['emerald', 'check'], 'rejected' => ['red', 'x']] as $status => $config)
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50
                        hover:shadow-lg hover:shadow-{{ $config[0] }}-500/10 transition-all duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-{{ $config[0] }}-500/20 rounded-lg p-3">
                        <svg class="w-6 h-6 text-{{ $config[0] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($config[1] === 'clock')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @elseif($config[1] === 'check')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            @endif
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold text-white">{{ ucfirst($status) }}</h2>
                        <p class="text-3xl font-bold text-{{ $config[0] }}-400">{{ $queuesByStatus[$status]->count() }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tabs and Table -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl border border-slate-700/50 overflow-hidden"
             x-data="{ activeTab: 'pending' }">
            <div class="border-b border-slate-700/50">
                <div class="flex space-x-2 p-4">
                    @foreach(['pending', 'ready', 'rejected'] as $status)
                    <button @click="activeTab = '{{ $status }}'"
                            :class="{ 'bg-teal-500/20 text-teal-400 border-teal-500': activeTab === '{{ $status }}',
                                     'text-gray-400 hover:text-white border-transparent': activeTab !== '{{ $status }}' }"
                            class="px-4 py-2 rounded-lg border transition-all duration-300 font-medium">
                        {{ ucfirst($status) }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="p-4">
                @foreach($queuesByStatus as $status => $queues)
                <div x-show="activeTab === '{{ $status }}'" x-cloak>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-700/50">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-800/50">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-800/50">Ticket Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-800/50">Order Info</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-800/50">Queue Time</th>
                                    @if($status === 'pending')
                                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-400 uppercase tracking-wider bg-slate-800/50">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @forelse($queues as $queue)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center">
                                                <span class="font-medium text-teal-400">{{ strtoupper(substr($queue->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-white">{{ $queue->user->name }}</div>
                                                <div class="text-sm text-slate-400">{{ $queue->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach($queue->tickets->groupBy('ticket_types') as $typeId => $tickets)
                                            <div class="font-medium text-white">
                                                {{ $tickets->first()->ticketType->name }}
                                                ({{ $tickets->count() }} tickets)
                                            </div>
                                            <div class="text-sm text-slate-400">
                                                Available: {{ $tickets->first()->ticketType->available_tickets }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-white">Rp {{ number_format($queue->total_amount, 0, ',', '.') }}</div>
                                        <div class="text-sm text-slate-400">Order #{{ $queue->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-white">{{ $queue->created_at->format('d M Y') }}</div>
                                        <div class="text-sm text-slate-400">{{ $queue->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    @if($status === 'pending')
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="{{ route('queue.approve', $queue->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white
                                                                    hover:from-teal-600 hover:to-emerald-600 transition-all duration-300
                                                                    hover:shadow-lg hover:shadow-teal-500/30 mr-2 text-sm font-medium">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('queue.reject', $queue->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="px-4 py-2 rounded-lg bg-slate-800 text-red-400 border border-red-500/20
                                                                    hover:bg-red-500/10 hover:border-red-500/30 transition-all duration-300
                                                                    hover:shadow-lg hover:shadow-red-500/10 text-sm font-medium">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="rounded-full bg-slate-800 p-4 mb-4">
                                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-white mb-1">No {{ $status }} tickets</h3>
                                            <p class="text-slate-400">There are no tickets in this category yet</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
