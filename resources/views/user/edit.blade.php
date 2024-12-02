@extends('layouts.app')

@section('content')
<div class="relative min-h-screen py-12">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 to-slate-800"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400">
                Edit User
            </h1>
            <p class="mt-2 text-gray-400">Update user information</p>
        </div>

        <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-8 border border-slate-700/50
                    hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500">

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                                          placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                                          placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                            <select id="role" name="role"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                                           placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white
                                          placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300"
                                   placeholder="Leave blank to keep current password">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ url()->previous() }}"
                           class="px-6 py-3 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white
                                  hover:bg-slate-700/50 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white
                                       hover:from-teal-600 hover:to-emerald-600 transform hover:-translate-y-0.5 transition-all duration-300
                                       hover:shadow-lg hover:shadow-teal-500/50">
                            Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

