<nav x-data="{ open: false }"
    class="sticky top-0 w-full z-50 bg-slate-900/30 backdrop-blur-lg border-b border-slate-700/50 glass-nav transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <svg class="w-8 h-8 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="text-teal-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                    <span
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">EventHub</span>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:justify-center flex-1">
                @auth
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('home') }}"
                            class="text-lg font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('home') ? 'text-teal-400 border-b-2 border-teal-400' : '' }} transition-all duration-300">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('event.index') }}"
                            class="text-lg font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('event.index') ? 'text-teal-400 border-b-2 border-teal-400' : '' }} transition-all duration-300">
                            {{ __('Events') }}
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="text-lg font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('dashboard') ? 'text-teal-400 border-b-2 border-teal-400' : '' }} transition-all duration-300">
                            {{ __('Dashboard') }}
                        </a>
                    </div>
                @endauth
                @guest
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('home') }}"
                            class="text-lg font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('home') ? 'text-teal-400 border-b-2 border-teal-400' : '' }} transition-all duration-300">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('event.index') }}"
                            class="text-lg font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('event.index') ? 'text-teal-400 border-b-2 border-teal-400' : '' }} transition-all duration-300">
                            {{ __('Events') }}
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Right side navigation -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white hover:bg-slate-700/50 transition-all duration-300">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 flex items-center justify-center text-white font-medium">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>{{ Auth::user()->name }}</div>
                    </a>
                @endauth
                @guest

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-slate-200 hover:text-teal-400 {{ request()->routeIs('login') ? 'text-teal-400' : '' }} transition-all duration-300">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white hover:from-teal-600 hover:to-emerald-600 active:from-teal-700 active:to-emerald-700 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-200 hover:text-white hover:bg-slate-700 focus:outline-none transition duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
