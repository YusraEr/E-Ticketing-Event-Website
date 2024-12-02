@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950" x-data="{ activeTab: 'users', showUserModal: false, showEventModal: false }"
        x-cloak>
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-96 h-96 -top-48 -left-48 bg-teal-500/20 rounded-full blur-3xl animate-blob"></div>
            <div
                class="absolute w-96 h-96 -bottom-48 -right-48 bg-emerald-500/20 rounded-full blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute w-96 h-96 top-1/2 left-1/2 bg-cyan-500/20 rounded-full blur-3xl animate-blob animation-delay-4000">
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Enhanced Tab Navigation -->
                <div class="mb-8 bg-slate-900/80 backdrop-blur-sm rounded-2xl p-2 border border-slate-800/80">
                    <nav class="flex space-x-4">
                        <button @click="activeTab = 'events'"
                            :class="{ 'bg-gradient-to-r from-teal-500 to-emerald-500 text-white': activeTab === 'events' }"
                            class="flex items-center px-6 py-3 text-sm font-medium rounded-lg text-gray-300 hover:text-white transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Event Management
                        </button>
                    </nav>
                </div>

                <!-- Content Sections -->
                @include('dashboard.section.eventManage')
            </div>
        </div>

        <!-- Event Edit Modal -->
        <div x-show="showEventModal" class="fixed inset-0 z-50 overflow-y-auto" x-transition>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showEventModal = false"></div>
                <div class="relative bg-slate-900 rounded-2xl border border-slate-800 w-full max-w-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4" x-text="editingEvent.id ? 'Edit Event' : 'Create Event'"></h3>
                    <form @submit.prevent="saveEvent">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Event Name</label>
                                <input type="text" x-model="editingEvent.name" class="mt-1 w-full rounded-lg bg-slate-800 border-slate-700 text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Description</label>
                                <textarea x-model="editingEvent.description" rows="3" class="mt-1 w-full rounded-lg bg-slate-800 border-slate-700 text-white"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Date</label>
                                <input type="datetime-local" x-model="editingEvent.event_date" class="mt-1 w-full rounded-lg bg-slate-800 border-slate-700 text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400">Image</label>
                                <input type="file" @change="handleImageUpload" accept="image/*" class="mt-1 w-full text-slate-400">
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" @click="showEventModal = false" class="px-4 py-2 text-sm text-slate-400 hover:text-white">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                    Save Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/dashboard/admin.js') }}" defer></script>
@endpush
