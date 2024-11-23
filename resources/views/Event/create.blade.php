@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Sticky Progress Bar -->
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-4xl mx-auto">
                <div class="flex-1">
                    <div class="relative">
                        <div class="h-3 bg-blue-100 rounded-full shadow-inner" role="progressbar">
                            <div class="h-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full transition-all duration-500 shadow-lg"
                                 style="width: 0%"
                                 id="form-progress"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm font-medium text-gray-600">Form Progress</span>
                            <span class="text-sm font-medium text-gray-700" id="progress-text">0% Complete</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <!-- Enhanced Header Section -->
                <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 px-8 py-10">
                    <h2 class="text-4xl font-bold text-white tracking-tight">Create New Event</h2>
                    <p class="mt-3 text-blue-100 text-lg max-w-2xl">Fill in the details below to create your event. All fields marked with * are required.</p>
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
                                <div class="bg-gray-50 p-6 rounded-xl space-y-6 shadow-sm">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">Basic Information</h3>

                                    <!-- Enhanced Event Name Input -->
                                    <div class="relative">
                                        <input type="text" name="name" id="name" required
                                               class="peer w-full px-4 py-3.5 rounded-lg border-2 border-gray-300
                                                      placeholder-transparent focus:border-blue-600 focus:ring-2
                                                      focus:ring-blue-100 transition duration-200 bg-white text-gray-900"
                                               placeholder="Event Name">
                                        <label for="name"
                                               class="absolute left-4 -top-2.5 bg-gray-50 px-2 text-sm text-gray-600
                                                      transition-all peer-placeholder-shown:text-base
                                                      peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-gray-400
                                                      peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                            Event Name *
                                        </label>
                                    </div>

                                    <!-- Enhanced Category Selection -->
                                    <div class="relative">
                                        <select name="category_id" required id="category_id"
                                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-600
                                                       focus:ring-0 transition duration-200 appearance-none cursor-pointer bg-white text-gray-900">
                                            <option value="" disabled selected>Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-xs text-gray-500">Choose the category that best fits your event type</p>
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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Description *</label>
                                        <div class="rounded-lg border-2 border-gray-300 focus-within:border-blue-600
                                                    focus-within:ring-2 focus-within:ring-blue-100 transition-all duration-200">
                                            <textarea name="description" id="description" rows="5" required maxlength="500"
                                                      class="w-full px-4 py-3 rounded-lg border-0 focus:ring-0 resize-none"></textarea>
                                            <div class="px-4 py-2 border-t border-gray-100 flex justify-between items-center bg-gray-50">
                                                <span class="text-xs text-gray-500">Use markdown for formatting</span>
                                                <span class="text-xs text-gray-500">
                                                    <span id="char-count">0</span>/500
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date & Location Card -->
                                <div class="bg-gray-50 p-6 rounded-xl space-y-6 shadow-sm">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">Date & Location</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="relative">
                                            <input type="datetime-local" name="event_date" id="event_date" required
                                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-600
                                                          focus:ring-0 transition duration-200 bg-white text-gray-900"
                                                   min="{{ date('Y-m-d\TH:i') }}">
                                            <p class="mt-1 text-xs text-gray-500">Select a future date and time for your event</p>
                                            @error('event_date')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="relative">
                                            <input type="text" name="location" id="location" required
                                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-600
                                                          focus:ring-0 transition duration-200 bg-white text-gray-900"
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
                                <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                                    <h3 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">Event Cover Image *</h3>
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
                                            class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition-colors">
                                            <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div class="mt-4">
                                                <label class="cursor-pointer">
                                                    <span
                                                        class="mt-2 block text-sm font-medium text-blue-600 hover:text-blue-500">Upload
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
                                <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                                    <div class="flex justify-between items-center border-b pb-3 mb-6">
                                        <h3 class="text-xl font-semibold text-gray-800">Ticket Categories</h3>
                                        <button type="button" id="add-category"
                                                class="px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50
                                                       rounded-lg border border-blue-200 transition-all duration-200">
                                            Add Category
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-4">You can create up to 3 ticket categories</p>
                                    <div id="ticket-categories" class="space-y-4">
                                        <div class="ticket-category bg-gray-50 p-4 rounded-lg">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                                    <input type="text" name="ticket_categories[]" required
                                                        class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Price</label>
                                                    <div class="mt-1 relative rounded-lg">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class=" text-gray-800  sm:text-sm">$</span>
                                                        </div>
                                                        <input type="number" name="ticket_prices[]" required
                                                            class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                                    <input type="number" name="ticket_quantities[]" required
                                                        class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="remove-category mt-2 text-red-600 text-sm hover:text-red-800"
                                                style="display: none;">
                                                Remove category
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Submit Button Section -->
                        <div class="flex items-center justify-end space-x-4 border-t pt-6">
                            <button type="button" onclick="window.history.back()"
                                    class="px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200
                                           transition-all duration-200">
                                Cancel
                            </button>
                            <button type="submit" id="submit-btn"
                                    class="group relative px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-700
                                           text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-800
                                           transition-all duration-200 shadow-lg hover:shadow-xl">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 hidden group-[.loading]:block">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span class="group-[.loading]:opacity-0">Create Event</span>
                            </button>
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
        class="absolute inset-4 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 bg-white rounded-lg shadow-xl sm:max-w-4xl w-full max-h-[90vh] overflow-auto">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Adjust Image</h3>
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
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" id="applyCrop"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Apply
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/event.js') }}"></script>
