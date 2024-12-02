@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-900 to-slate-800">
    <!-- Sticky Progress Bar -->
    <div class="sticky top-[65px] z-40 bg-slate-900/80 backdrop-blur-sm border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex-1">
                    <div class="relative">
                        <div class="h-3 bg-slate-700 rounded-full shadow-inner" role="progressbar">
                            <div class="h-3 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-full transition-all duration-500 shadow-lg"
                                 style="width: 0%"
                                 id="form-progress"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm font-medium text-gray-400">Form Progress</span>
                            <span class="text-sm font-medium text-teal-400" id="progress-text">0% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-slate-700/50 transition-all duration-300 hover:shadow-teal-500/10">
                <!-- Enhanced Header Section -->
                <div class="bg-gradient-to-r from-slate-900 via-teal-900 to-slate-900 px-8 py-10">
                    <h2 class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">Create New Event</h2>
                    <p class="mt-3 text-gray-300 text-lg max-w-2xl">Fill in the details below to create your event. All fields marked with * are required.</p>
                </div>

                <!-- Form Section - Enhanced Layout -->
                <div class="px-8 py-10">
                    <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data" id="event-form"
                          class="space-y-10">
                        @csrf
                        <input type="hidden" name="cropped_image" id="cropped_image">

                        <!-- Two Column Layout for Desktop -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column - Main Details -->
                            <div class="space-y-8">
                                <!-- Event Basic Info Card -->
                                <div class="bg-slate-800/30 p-6 rounded-xl space-y-6 border border-slate-700/50">
                                    <h3 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 border-b border-slate-700/50 pb-3">Basic Information</h3>

                                    <!-- Enhanced Event Name Input -->
                                    <div class="relative group">
                                        <input type="text" name="name" id="name" required
                                               class="peer w-full px-4 py-3.5 rounded-lg bg-slate-900/50 border-2 border-slate-700/50
                                                      text-gray-200 placeholder-transparent focus:border-teal-500 focus:ring-2
                                                      focus:ring-teal-500/20 transition duration-200"
                                               placeholder="Event Name">
                                        <label for="name"
                                               class="absolute left-4 -top-2.5 bg-slate-800 px-2 text-sm text-gray-400
                                                      transition-all peer-placeholder-shown:text-base
                                                      peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-gray-500
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-teal-400">
                                            Event Name *
                                        </label>
                                    </div>

                                    <!-- Enhanced Category Selection -->
                                    <div class="relative">
                                        <select name="category_id" required id="category_id"
                                                class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50
                                                       text-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20
                                                       transition duration-200 appearance-none cursor-pointer">
                                            <option value="" disabled selected>Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20">
                                                <path fill="currentColor" d="M7 7l3 3 3-3v2L10 12 7 9z"/>
                                            </svg>
                                        </div>
                                        @error('category_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Enhanced Description Field -->
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Event Description *</label>
                                        <div class="rounded-lg bg-slate-900/50 border-2 border-slate-700/50 focus-within:border-teal-500
                                                    focus-within:ring-2 focus-within:ring-teal-500/20 transition-all duration-200">
                                            <textarea name="description" id="description" rows="5" required maxlength="1500"
                                                      class="w-full px-4 py-3 rounded-lg bg-transparent border-0 text-gray-200
                                                             focus:ring-0 resize-none"></textarea>
                                            <div class="px-4 py-2 border-t border-slate-700/50 flex justify-between items-center bg-slate-800/30">
                                                <span class="text-xs text-gray-500">Use markdown for formatting</span>
                                                <span class="text-xs text-gray-500">
                                                    <span id="char-count">0</span>/1500
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date & Location Card -->
                                <div class="bg-slate-800/30 p-6 rounded-xl space-y-6 border border-slate-700/50">
                                    <h3 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 border-b border-slate-700/50 pb-3">Date & Location</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="relative">
                                            <input type="datetime-local" name="event_date" id="event_date" required
                                                   class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50
                                                          text-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20
                                                          transition duration-200"
                                                   min="{{ date('Y-m-d\TH:i') }}">
                                            <p class="mt-1 text-xs text-gray-500">Select a future date and time for your event</p>
                                            @error('event_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <input type="text" name="location" id="location" required
                                                   class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border-2 border-slate-700/50
                                                          text-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20
                                                          transition duration-200"
                                                   placeholder="Enter venue or address">
                                            <p class="mt-1 text-xs text-gray-500">Provide the full address or venue name</p>
                                            @error('location')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Image & Tickets -->
                            <div class="space-y-8">
                                <!-- Enhanced Image Upload Card -->
                                <div class="bg-slate-800/30 p-6 rounded-xl border border-slate-700/50">
                                    <h3 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 border-b border-slate-700/50 pb-3 mb-6">Event Cover Image *</h3>
                                    <div class="mt-1 relative">
                                        <div id="image-preview" class="hidden">
                                            <div class="relative group cursor-pointer">
                                                <img src="" alt="Preview"
                                                    class="w-full aspect-video object-cover rounded-xl">
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <div class="text-white text-center">
                                                        <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        <p class="mt-2 text-sm">Click to change image</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="upload-instructions"
                                            class="border-2 border-dashed border-slate-700/50 rounded-xl p-8 text-center hover:border-teal-500 transition-colors">
                                            <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div class="mt-4">
                                                <label class="cursor-pointer">
                                                    <span
                                                        class="mt-2 block text-sm font-medium text-teal-400 hover:text-teal-300">Upload
                                                        a cover image</span>
                                                    <input id="image-input" type="file" name="image" accept="image/*" required
                                                        class="sr-only">
                                                </label>
                                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                            </div>
                                            @error('image')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Ticket Categories Card -->
                                <div class="bg-slate-800/30 p-6 rounded-xl border border-slate-700/50">
                                    <div class="flex justify-between items-center border-b border-slate-700/50 pb-3 mb-6">
                                        <h3 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                                            Ticket Categories
                                        </h3>
                                        <button type="button" id="add-category"
                                                class="group px-4 py-2 text-sm font-medium text-teal-400 hover:bg-slate-700/50
                                                       rounded-lg border border-teal-500/50 hover:border-teal-400
                                                       transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span class="group-hover:translate-x-0.5 transition-transform">Add Category</span>
                                        </button>
                                    </div>

                                    <div class="relative">
                                        <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-500 to-emerald-500 rounded-lg blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                                        <div id="ticket-categories" class="relative space-y-4">
                                            <!-- Ticket category template - Enhanced version -->
                                            <div class="ticket-category bg-slate-800/30 p-4 rounded-lg border border-slate-700/50
                                                        hover:border-teal-500/50 transition-colors duration-300">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-300">Category Name</label>
                                                        <input type="text" name="ticket_categories[]" required
                                                            class="mt-1 block w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-200 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-300">Price</label>
                                                        <div class="mt-1 relative rounded-lg">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class=" text-gray-300  sm:text-sm">Rp</span>
                                                            </div>
                                                            <input type="number" name="ticket_prices[]" required
                                                                class="pl-7 block w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-200 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-300">Quantity</label>
                                                        <input type="number" name="ticket_quantities[]" required
                                                            class="mt-1 block w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-gray-200 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="remove-category mt-3 px-3 py-1 text-red-400 text-sm hover:text-red-300
                                                           hover:bg-red-900/20 rounded-md transition-all duration-200 flex items-center gap-2"
                                                    style="display: none;">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Remove category
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Form Navigation -->
                        <div class="flex items-center justify-between border-t border-slate-700/50 pt-6">
                            <div class="flex items-center text-sm text-gray-400">
                                <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>All fields marked with * are required</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="window.history.back()"
                                        class="px-6 py-3 text-gray-300 bg-slate-800 rounded-lg hover:bg-slate-700
                                               transition-all duration-200 border border-slate-600 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </button>
                                <button type="submit" id="submit-btn"
                                        class="group relative px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-500
                                               text-white font-medium rounded-lg hover:from-teal-600 hover:to-emerald-600
                                               transition-all duration-200 shadow-lg hover:shadow-teal-500/50
                                               transform hover:-translate-y-0.5 flex items-center gap-2">
                                    Create Event
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Crop Modal -->
<div id="cropModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div
        class="absolute inset-4 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 bg-slate-800 rounded-lg shadow-xl sm:max-w-4xl w-full max-h-[90vh] overflow-auto">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-300">Adjust Image</h3>
                <button type="button" id="closeCropModal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative max-h-[70vh] overflow-hidden">
                <img id="cropperImage" src="" alt="Crop preview" class="max-w-full">
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <button type="button" id="cancelCrop"
                    class="px-4 py-2 text-sm font-medium text-gray-300 bg-slate-700 border border-slate-600 rounded-md hover:bg-slate-600">
                    Cancel
                </button>
                <button type="button" id="applyCrop"
                    class="px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-md hover:bg-teal-600">
                    Apply
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="{{ asset('js/event/create.js') }}"></script>
    <script src="{{ asset('js/event.js') }}"></script>
@endpush
