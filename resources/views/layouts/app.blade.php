<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Wanderlust') }}</title>
    <meta name="description" content="{{ $description ?? 'Discover extraordinary travel destinations across the archipelago.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
        .nav-transparent { background: transparent; }
        .nav-solid { background: rgba(255,255,255,0.97); backdrop-filter: blur(12px); box-shadow: 0 1px 20px rgba(0,0,0,0.08); }
        .nav-link-light { color: rgba(255,255,255,0.9); }
        .nav-link-dark { color: #374151; }
        .hero-overlay { background: linear-gradient(to bottom, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.1) 40%, rgba(0,0,0,0.55) 100%); }
    </style>
    @stack('styles')
</head>
<body class="font-body bg-white antialiased">

    {{-- ════════════════════════════════════════ NAVBAR ════════════════════════════════════════ --}}
    <nav id="navbar"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 nav-transparent"
         x-data="{ open: false, scrolled: false }"
         x-init="
            window.addEventListener('scroll', () => {
                scrolled = window.scrollY > 60;
                document.getElementById('navbar').className = scrolled
                    ? 'fixed top-0 left-0 right-0 z-50 transition-all duration-300 nav-solid'
                    : 'fixed top-0 left-0 right-0 z-50 transition-all duration-300 nav-transparent';
            })
         ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-18">

                {{-- Logo --}}
                <a href="{{ route('home') }}"
                   class="font-display font-bold text-xl tracking-wide transition-colors"
                   :class="scrolled ? 'text-gray-900' : 'text-white'">
                    Wanderlust
                </a>

                {{-- Nav Links (desktop) --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}"
                       class="text-sm font-medium transition-colors hover:opacity-70"
                       :class="scrolled ? 'text-gray-700' : 'text-white'">
                        Home
                    </a>
                    <a href="{{ route('articles.search') }}"
                       class="text-sm font-medium transition-colors hover:opacity-70"
                       :class="scrolled ? 'text-gray-700' : 'text-white'">
                        Categories
                    </a>
                    @auth
                        {{-- User dropdown --}}
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown"
                                class="flex items-center gap-2 text-sm font-medium transition-colors hover:opacity-70"
                                :class="scrolled ? 'text-gray-700' : 'text-white'">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs border border-white/30"
                                     :class="scrolled ? 'bg-gray-100 border-gray-200 text-gray-700' : 'bg-white/20 border-white/30 text-white'">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false" x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('favorites.index') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    My Favorites
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile
                                </a>
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium transition-colors hover:opacity-70"
                           :class="scrolled ? 'text-gray-700' : 'text-white'">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-5 py-2 rounded-full transition-colors shadow-sm">
                            Get Started
                        </a>
                    @endauth
                </div>

                {{-- Hamburger (mobile) --}}
                <button @click="open = !open"
                        class="md:hidden p-2 rounded-lg transition-colors"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Home</a>
                <a href="{{ route('articles.search') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Categories</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Admin Panel</a>
                    @endif
                    <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">My Favorites</a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-3 px-3 py-2.5 text-sm text-red-500 hover:bg-red-50 rounded-lg">Sign Out</button>
                    </form>
                @else
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center border border-gray-300 text-gray-700 text-sm font-medium py-2.5 rounded-full">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-sky-500 text-white text-sm font-semibold py-2.5 rounded-full">Get Started</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ════════════════════════════════════════ MAIN CONTENT ════════════════════════════════════════ --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ════════════════════════════════════════ FOOTER ════════════════════════════════════════ --}}
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10">
                <div class="col-span-2 md:col-span-1">
                    <a href="{{ route('home') }}" class="font-display font-bold text-2xl text-white block mb-3">
                        Wanderlust
                    </a>
                    <p class="text-sm leading-relaxed text-gray-500">
                        Discover extraordinary places and share your journey with the world.
                    </p>
                </div>
                <div>
                    <h5 class="text-white text-sm font-semibold mb-4">Explore</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('articles.search') }}" class="hover:text-white transition-colors">All Articles</a></li>
                        <li><a href="{{ route('articles.search', ['sort' => 'popular']) }}" class="hover:text-white transition-colors">Popular</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white text-sm font-semibold mb-4">Account</h5>
                    <ul class="space-y-2.5 text-sm">
                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Sign Up</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('favorites.index') }}" class="hover:text-white transition-colors">My Favorites</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition-colors">Profile</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h5 class="text-white text-sm font-semibold mb-4">Contact</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-600">&copy; {{ date('Y') }} Wanderlust Editorial. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    {{-- Social icons --}}
                    <a href="#" class="text-gray-600 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
