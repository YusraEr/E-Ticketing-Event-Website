<div x-show="activeTab === 'users'"
     x-data="{
        searchQuery: '',
        filterUsers(user) {
            return this.searchQuery === '' ||
                user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                user.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                user.role.toLowerCase().includes(this.searchQuery.toLowerCase());
        },
        resetFilters() {
            this.searchQuery = '';
        }
     }"
     x-transition:enter="transition-all ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="grid grid-cols-1 gap-6">

    <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800/80 overflow-hidden hover:border-teal-500/50 transition-all duration-300">
        <div class="p-6 border-b border-slate-800/80 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white">User Management</h2>
            <a href="{{ route('user.create') }}" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg transition-colors">
                Create User
            </a>
        </div>

        <!-- Add Search Section -->
        <div class="p-4 border-b border-slate-800/80">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text"
                                   x-model="searchQuery"
                                   placeholder="Search users..."
                                   class="w-full sm:w-64 pl-10 pr-4 py-2 bg-slate-950/50 backdrop-blur-sm border border-slate-800/50 text-white rounded-lg focus:ring-2 focus:ring-teal-500/50 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>
                </div>
                <div class="flex items-end">
                    <button @click="resetFilters"
                        class="px-6 py-3 bg-slate-700/50 text-white rounded-xl hover:bg-slate-600/50 transition-all duration-300">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-800">
                <thead class="bg-slate-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-900/30 divide-y divide-slate-800" id="userTable">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-800/50 transition-colors"
                        data-user-id="{{ $user->id }}"

                        x-show="filterUsers({
                            name: '{{ $user->name }}',
                            email: '{{ $user->email }}',
                            role: '{{ $user->role }}'
                        })"
                        x-transition>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">{{ $user->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{route('user.edit', $user->id)}}" class="text-teal-400 hover:text-teal-300 transition-colors">Edit</a>
                            <button @click="deleteUser({{ $user->id }})" class="text-red-400 hover:text-red-300 transition-colors">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteUser(userId) {

            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`/user/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        document.querySelector(`tr[data-user-id="${userId}"]`).remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</div>


