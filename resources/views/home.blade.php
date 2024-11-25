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

    <link rel="stylesheet" href="{{asset('style/home.css')}}">

</head>

<body class="bg-gradient-to-b from-slate-900 to-slate-800 min-h-screen">
    <!-- Navbar with glass effect -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        EventHub
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-4 py-2 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white hover:bg-slate-700/50 transition-all duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-slate-700 dark:text-slate-200 hover:text-slate-900 transition-all duration-300">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-0.5">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Parallax -->
    <div class="relative h-screen overflow-hidden">
        <div class="absolute inset-0 hero-parallax">
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
                 class="w-full h-full object-cover" alt="Hero background">
            <div class="absolute inset-0 bg-black opacity-45"></div>
        </div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                <h1 class="text-5xl md:text-7xl font-bold  mb-6">
                    <span class="text-white hero-text-shadow">Discover</span>
                    <span class="text-emerald-400 hero-text-shadow bg-clip-text bg-gradient-to-r from-teal-300 to-emerald-300">Amazing Events</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-100 mb-8 max-w-2xl mx-auto hero-text-shadow desc-text-shadow">
                    Join unforgettable experiences and create lasting memories with our curated selection of events
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('event.index')}}"
                       class="px-8 py-4 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1">
                        Explore Events
                    </a>
                    <a href="#featured"
                       class="px-8 py-4 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white hover:bg-slate-700/50 transition-all duration-300">
                        View Featured
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Search Section -->
    <div class="relative -mt-24 z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-800/40 backdrop-blur-xl rounded-2xl shadow-lg search-container p-8 transition-all duration-300">
            <form action="" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Events</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search"
                            class="w-full p-4 pl-12 text-base rounded-xl bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400
                            focus:ring-teal-500 focus:border-teal-500 transition-all duration-300"
                            placeholder="Search for events..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="md:w-48">
                    <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                    <select name="category" id="category"
                        class="w-full p-4 rounded-xl bg-slate-900/50 border border-slate-700/50 text-white
                        focus:ring-teal-500 focus:border-teal-500 transition-all duration-300">
                        <option value="">All Categories</option>
                        <option value="music">Music</option>
                        <option value="sports">Sports</option>
                        <option value="arts">Arts</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-xl
                        hover:from-teal-600 hover:to-emerald-600 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2
                        focus:ring-offset-slate-900 transition-all duration-300 transform hover:-translate-y-0.5">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Latest Events Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-8">
                Featured Events
            </h2>
            <div class="swiper eventSwiper">
                <div class="swiper-wrapper">
                    @foreach ($events as $event)
                    <div class="swiper-slide">
                        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden group
                             hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1 h-[400px] flex flex-col">
                            <div class="relative overflow-hidden h-48 flex-shrink-0">
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                                <span class="absolute top-2 left-2 px-2 py-1 bg-slate-900/70 backdrop-blur-sm text-teal-400 rounded-lg text-xs font-medium border border-teal-500/20">
                                    {{ $event->category ? $event->category->name : 'No Category' }}
                                </span>
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 truncate max-w-[70%]">{{$event->name}}</h3>
                                </div>

                                <div class="space-y-2 mb-4 flex-grow">
                                    <p class="text-sm text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="truncate">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                    </p>
                                    <p class="text-sm text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-teal-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="truncate">{{$event->location}}</span>
                                    </p>
                                </div>

                                <a href="{{ route('event.show', $event->id) }}"
                                   class="inline-flex items-center justify-center w-full px-4 py-2 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform group-hover:scale-[1.02] shadow-lg hover:shadow-teal-500/50 mt-auto">
                                    <span>View Details</span>
                                    <svg class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
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

        <!-- Popular Events -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-emerald-400 mb-8">
                Popular Events
            </h2>
            <div class="swiper popularSwiper">
                <div class="swiper-wrapper">
                    @foreach($events as $event)
                    <div class="swiper-slide">
                        <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl shadow-lg border border-slate-700/50 overflow-hidden group
                             hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ asset('storage/' . $event->image) }}"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-500"
                                     alt="{{ $event->name }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-teal-400 text-lg mb-2">{{ $event->name }}</h3>
                                <div class="flex items-center text-sm text-gray-400 space-x-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        <span>{{ $event->attendees_count ?? 0 }} attending</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span>{{ $event->views_count ?? 0 }} views</span>
                                    </div>
                                </div>
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

    </main>

    <!-- Why EventHub Section -->
    <div class="bg-slate-900/50 backdrop-blur-sm py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                        Why EventHub?
                    </span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Discover what makes EventHub the perfect platform for all your event needs
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50
                     hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 hover:transform hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-gradient-to-br from-teal-500 to-emerald-500 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Secure Booking</h3>
                    <p class="text-gray-400">Advanced encryption and secure payment methods to protect your transactions</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50
                     hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 hover:transform hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-gradient-to-br from-teal-500 to-emerald-500 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Easy Management</h3>
                    <p class="text-gray-400">Intuitive tools to manage your bookings, tickets, and event preferences</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-6 border border-slate-700/50
                     hover:shadow-teal-500/20 hover:shadow-2xl hover:border-teal-500/50 hover:transform hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-gradient-to-br from-teal-500 to-emerald-500 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Instant Updates</h3>
                    <p class="text-gray-400">Real-time notifications about event changes, updates, and special offers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Us Section -->
    <div class="relative py-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 to-slate-800/90 backdrop-blur-sm"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-4xl font-bold mb-6">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                            Get in Touch
                        </span>
                    </h2>
                    <p class="text-gray-400 mb-8">
                        Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center justify-center md:justify-start space-x-4">
                            <div class="bg-gradient-to-br from-teal-500 to-emerald-500 w-10 h-10 rounded-lg flex items-center justify-center">

                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-gray-300">support@eventhub.com</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start space-x-4">
                            <div class="bg-gradient-to-br from-teal-500 to-emerald-500 w-10 h-10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="text-gray-300">+1 (555) 123-4567</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/30 backdrop-blur-sm rounded-xl p-8 border border-slate-700/50
                     hover:shadow-teal-500/10 hover:shadow-2xl hover:border-teal-500/30 transition-all duration-500">
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300" placeholder="Your name">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300" placeholder="your@email.com">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg bg-slate-900/50 border border-slate-700/50 text-white placeholder-gray-400 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-300" placeholder="Your message"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full px-6 py-3 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-medium
                                   hover:from-teal-600 hover:to-emerald-600 transform hover:-translate-y-0.5 transition-all duration-300
                                   hover:shadow-lg hover:shadow-teal-500/50">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Call to Action Section -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-8 md:p-12 shadow-lg border border-slate-700/50">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-4">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-400">
                            Ready to Join the Experience?
                        </span>
                    </h2>
                    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                        Create an account to unlock exclusive features, save your favorite events, and get personalized recommendations.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 rounded-lg bg-gradient-to-r from-teal-500 to-emerald-500 text-white hover:from-teal-600 hover:to-emerald-600 transition-all duration-300 transform hover:-translate-y-1">
                            Log In Now
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 rounded-lg bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 text-white hover:bg-slate-700/50 transition-all duration-300">
                            Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-800/50 backdrop-blur-sm border-t border-slate-700/50">
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
    <script>
        // Add parallax effect

    </script>
</body>

</html>

