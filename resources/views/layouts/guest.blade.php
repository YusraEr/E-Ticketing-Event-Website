<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
    <link href="{{ asset('style/guest.css') }}" rel="stylesheet">
    <script src="{{ asset('js/guest.js') }}" defer></script>
</head>

<body class="font-sans antialiased bg-slate-900 text-white min-h-screen relative overflow-x-hidden">
    <!-- Animated Background Shapes -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute w-[500px] h-[500px] bg-teal-500/10 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Navigation with improved design -->
    <nav class="fixed w-full z-50 backdrop-blur-md bg-slate-900/50 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-3 group">
                    <div class="relative">
                        <svg class="w-8 h-8 text-teal-500 transform transition-transform group-hover:rotate-180 duration-700"
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                        <div class="absolute inset-0 bg-teal-500/20 blur-xl rounded-full scale-0 group-hover:scale-150 transition-transform duration-700"></div>
                    </div>
                    <a href="/"
                        class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        EventHub
                    </a>
                </div>
                @auth
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50
                                    text-gray-300 hover:bg-slate-700/50 transition-all duration-300">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen relative z-10">
        @yield('content')
    </div>

    <!-- Enhanced Footer -->
    <footer class="relative z-10 bg-slate-800/30 backdrop-blur-md border-t border-slate-700/50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center text-sm text-gray-400">
                &copy; {{ date('Y') }} EventHub. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
