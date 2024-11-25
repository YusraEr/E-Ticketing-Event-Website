<section class="h-full flex flex-col">
    <header class="mb-6">
        <h2 class="text-2xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-red-400 to-rose-400">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-2 text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <div class="flex-grow flex items-center justify-center">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white font-medium
            hover:from-red-600 hover:to-rose-600 transition-all duration-300 transform hover:-translate-y-0.5"
        >{{ __('Delete Account') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-semibold text-slate-200 mb-4">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-400 mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="space-y-4">
                <div>
                    <x-input-label for="password" value="{{ __('Password') }}" class="text-slate-300" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-red-500 focus:ring-red-500 text-slate-200"
                        placeholder="{{ __('Enter your password to confirm') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="px-4 py-2 rounded-xl bg-slate-800 text-slate-200 border border-slate-700/50 hover:bg-slate-700/50 transition-all duration-300">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white font-medium
                    hover:from-red-600 hover:to-rose-600 transition-all duration-300 transform hover:-translate-y-0.5">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
