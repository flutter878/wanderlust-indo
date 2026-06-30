<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Artikel Wisata') }}</title>
    <meta name="description" content="{{ $description ?? 'Jelajahi destinasi wisata nusantara terbaik — pantai, gunung, sejarah, kuliner, dan lebih banyak lagi.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- ════════════════════════════════════════ NAVBAR ════════════════════════════════════════ --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-primary-600 font-bold text-xl">
                    <span class="text-2xl">🌏</span>
                    <span>Artikel Wisata</span>
                </a>

                {{-- Search Bar (desktop) --}}
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('articles.search') }}" method="GET" class="w-full flex">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari destinasi wisata..."
                            class="w-full border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        <button type="submit"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-r-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Nav Links (desktop) --}}
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        {{-- User dropdown --}}
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown"
                                class="flex items-center gap-2 text-gray-700 hover:text-primary-600 text-sm font-medium">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false" x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <span>🛠️</span> Dashboard Admin
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <span>👤</span> Profil
                                </a>
                                <a href="{{ route('favorites.index') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <span>❤️</span> Favorit Saya
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <span>🚪</span> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-600 hover:text-primary-600 text-sm font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>

                {{-- Hamburger (mobile) --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-600 hover:text-primary-600 hover:bg-gray-100">
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
        <div x-show="open" x-cloak class="md:hidden border-t border-gray-100 bg-white px-4 pb-4">
            {{-- Search (mobile) --}}
            <form action="{{ route('articles.search') }}" method="GET" class="flex mt-3 mb-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari destinasi wisata..."
                    class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="submit" class="bg-primary-600 text-white px-3 py-2 rounded-r-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            @auth
                <div class="space-y-1">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">🛠️ Dashboard Admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">👤 Profil</a>
                    <a href="{{ route('favorites.index') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">❤️ Favorit Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">🚪 Keluar</button>
                    </form>
                </div>
            @else
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('login') }}" class="flex-1 text-center border border-primary-600 text-primary-600 text-sm font-medium px-4 py-2 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center bg-primary-600 text-white text-sm font-medium px-4 py-2 rounded-lg">Daftar</a>
                </div>
            @endauth
        </div>
    </nav>

    {{-- ════════════════════════════════════════ MAIN CONTENT ════════════════════════════════════════ --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ════════════════════════════════════════ FOOTER ════════════════════════════════════════ --}}
    <footer class="bg-gray-800 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 text-white font-bold text-lg mb-3">
                        <span class="text-2xl">🌏</span>
                        <span>Artikel Wisata</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Platform artikel destinasi wisata nusantara. Temukan keindahan Indonesia dari ujung Sabang sampai Merauke.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Kategori</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('articles.search', ['category' => 'pantai']) }}" class="hover:text-primary-400 transition-colors">🏖️ Pantai</a></li>
                        <li><a href="{{ route('articles.search', ['category' => 'gunung']) }}" class="hover:text-primary-400 transition-colors">🏔️ Gunung</a></li>
                        <li><a href="{{ route('articles.search', ['category' => 'sejarah']) }}" class="hover:text-primary-400 transition-colors">🏛️ Sejarah</a></li>
                        <li><a href="{{ route('articles.search', ['category' => 'kuliner']) }}" class="hover:text-primary-400 transition-colors">🍜 Kuliner</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Tautan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Beranda</a></li>
                        @guest
                            <li><a href="{{ route('login') }}" class="hover:text-primary-400 transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-primary-400 transition-colors">Daftar</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Artikel Wisata. Dibuat dengan ❤️ untuk nusantara.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
