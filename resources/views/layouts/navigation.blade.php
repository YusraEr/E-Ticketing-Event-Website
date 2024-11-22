<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-700 backdrop-filter backdrop-blur-lg bg-opacity-30">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('logo.png') }}" class="block h-9 w-auto" alt="Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white">
                            {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('event.index') }}" class="text-sm font-medium text-gray-300 hover:text-white">
                            {{ __('Events') }}
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('event.index') }}" class="text-sm font-medium text-gray-300 hover:text-white">
                            {{ __('Events') }}
                        </a>
                    @endguest
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <div class="relative">
                        <button @click="open = ! open" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                {{ __('Profile') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-300 hover:text-white">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden backdrop-filter backdrop-blur-lg bg-opacity-30">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('event.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    {{ __('Events') }}
                </a>
            </div>
            <div class="pt-4 pb-1 border-t border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                        {{ __('Profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">

                        @csrf
                        <a href="{{ route('logout') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        @endauth
        @guest
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('event.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    {{ __('Events') }}
                </a>
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                    {{ __('Register') }}
                </a>
            </div>
        @endguest
    </div>
</nav>

