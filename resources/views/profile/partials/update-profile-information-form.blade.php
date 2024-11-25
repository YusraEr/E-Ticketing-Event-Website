<section>
    <header class="mb-6">
        <h2 class="text-2xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-4">
            <!-- Name Input -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-slate-300" />
                <x-text-input id="name" name="name" type="text"
                    class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-teal-500 focus:ring-teal-500 text-slate-200"
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email Input -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-300" />
                <x-text-input id="email" name="email" type="email"
                    class="mt-1 block w-full bg-slate-900/50 border-slate-700/50 rounded-xl focus:border-teal-500 focus:ring-teal-500 text-slate-200"
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-slate-400">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-teal-400 hover:text-teal-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-emerald-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-400">
                    {{ __('Saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
