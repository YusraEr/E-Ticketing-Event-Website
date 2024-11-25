<section>
    <header class="mb-8">
        <h2 class="text-2xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
            {{ __('Security Settings') }}
        </h2>
        <p class="mt-2 text-slate-400">
            {{ __('Manage your password and security preferences to keep your account safe.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <!-- Current Password -->
                <div>
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-slate-300 mb-2" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-teal-500 focus:ring-teal-500 text-slate-200"
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <!-- New Password -->
                <div>
                    <x-input-label for="update_password_password" :value="__('New Password')" class="text-slate-300 mb-2" />
                    <x-text-input id="update_password_password" name="password" type="password"
                        class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-teal-500 focus:ring-teal-500 text-slate-200"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-slate-300 mb-2" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-teal-500 focus:ring-teal-500 text-slate-200"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex flex-col justify-center p-6 bg-slate-900/30 rounded-xl border border-slate-700/30">
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-slate-200">Password Requirements:</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            Minimum 8 characters
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            At least one uppercase letter
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            At least one number
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-400">
                    {{ __('Password updated successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
