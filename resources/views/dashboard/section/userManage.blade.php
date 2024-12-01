<div x-show="activeTab === 'users'"
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
                    <tr class="hover:bg-slate-800/50 transition-colors" data-user-id="{{ $user->id }}">
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

