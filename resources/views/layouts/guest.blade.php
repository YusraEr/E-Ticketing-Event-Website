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
    </head>
    <body class="font-sans antialiased bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen">
        <!-- Navigation -->
        <nav class="fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
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
        <div class="min-h-screen">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-slate-800/30 backdrop-blur-sm border-t border-slate-700/50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} EventHub. All rights reserved.
                </div>
            </div>
        </footer>
    </body>
</html>
