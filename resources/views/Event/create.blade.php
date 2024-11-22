@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Create New Event</h2>
                    <p class="mt-1 text-blue-100">Fill in the details to create your amazing event</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-6">
                    <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden input for cropped image -->
                        <input type="hidden" name="cropped_image" id="cropped_image">

                        <!-- Event Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Name</label>
                            <input type="text" name="name" required
                                class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4" required
                                class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150"></textarea>
                        </div>

                        <!-- Date & Location Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Date</label>
                                <input type="datetime-local" name="event_date" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" required
                                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition duration-150">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Cover Image</label>
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
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Categories Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Ticket Categories</label>
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
                                                    <span class="text-gray-500 sm:text-sm">$</span>
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

                            <button type="button" id="add-category"
                                class="mt-4 px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                                + Add Ticket Category
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                                Create Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Crop Modal -->
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
