<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .swiper {
            padding-bottom: 50px !important;
        }
        .swiper-pagination {
            bottom: 0 !important;
        }
        .swiper-button-next, .swiper-button-prev {
            top: calc(50% - 25px) !important;
            width: 40px !important;
            height: 40px !important;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            backdrop-filter: blur(4px);
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transform: scale(1.1);
        }

        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px !important;
            color: #4f46e5;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                        YourLogo
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white transition">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="bg-white dark:bg-gray-800 shadow-sm pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="" method="GET" class="flex items-center justify-center">
                <div class="relative w-full max-w-lg">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="search" id="search"
                        class="w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Search for events..." value="{{ request('search') }}">
                    <button type="submit"
                        class="absolute right-2 top-2 bg-indigo-600 text-white px-4 py-1 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">
                    Welcome to Your Application
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                    A modern and minimalist platform built with Laravel
                </p>
                <div class="flex justify-center space-x-4">
                    <a href=""
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Get Started
                    </a>
                    <a href=""
                        class="px-6 py-3 border border-gray-300 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

        <!-- Latest Events Carousel -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Latest Events</h2>
            <div class="swiper eventSwiper">
                <div class="swiper-wrapper">
                    <!-- Event Card -->
                    @foreach ($events as $event)
                    <div class="swiper-slide">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Event Title {{$event->name}}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{$event->location}}
                                </p>

                                <a href="{{ route('event.show', $event->id) }}" class="mt-3 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <!-- Popular Tickets Carousel -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Popular Tickets</h2>
            <div class="swiper ticketSwiper">
                <div class="swiper-wrapper">
                    <!-- Ticket Card -->
                    @for ($i = 1; $i <= 5; $i++)
                    <div class="swiper-slide">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ticket Package {{$i}}</h3>
                                <div class="mt-2 flex items-center">
                                    <span class="text-2xl font-bold text-indigo-600">${{$i}}99</span>
                                    <span class="ml-2 text-sm text-gray-500">/ person</span>
                                </div>
                                <div class="mt-3 space-y-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">✓ Feature 1</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">✓ Feature 2</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">✓ Feature 3</p>
                                </div>
                                <button class="mt-4 w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="text-gray-500 dark:text-gray-400 text-sm">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex space-x-6">
                        <a href="" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">About</span>
                            About
                        </a>
                        <a href="" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Contact</span>
                            Contact
                        </a>
                        <a href="" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Privacy</span>
                            Privacy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
