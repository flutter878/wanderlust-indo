<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Artikel Wisata CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- TinyMCE CDN --}}
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    @stack('styles')
</head>
<body class="h-full" x-data="{ sidebarOpen: false }">

<div class="flex h-full">

    {{-- ═══════════════════════════ SIDEBAR ═══════════════════════════ --}}
    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
         class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

    <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 text-white flex flex-col transform transition-transform duration-200
                  lg:translate-x-0 lg:static lg:z-auto"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-700">
            <span class="text-2xl">🌏</span>
            <div>
                <div class="font-bold text-sm">Artikel Wisata</div>
                <div class="text-xs text-gray-400">CMS Admin Panel</div>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                Dashboard
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Konten</p>
            </div>

            {{-- Artikel --}}
            <a href="{{ route('admin.articles.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.articles.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Artikel
            </a>

            {{-- Kategori --}}
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.categories.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Interaksi</p>
            </div>

            {{-- Komentar --}}
            <a href="{{ route('admin.comments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.comments.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Moderasi Komentar
            </a>

            <div class="pt-3 pb-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Lainnya</p>
            </div>

            {{-- Lihat Website --}}
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Website
            </a>
        </nav>

        {{-- User Info + Logout --}}
        <div class="border-t border-gray-700 px-4 py-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════════════════════════ MAIN CONTENT ═══════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 py-3 flex items-center gap-4">
            {{-- Hamburger mobile --}}
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-1 rounded-md text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title --}}
            <h1 class="text-lg font-semibold text-gray-800 flex-1">
                {{ $title ?? 'Dashboard' }}
            </h1>

            {{-- Quick actions --}}
            <a href="{{ route('admin.articles.create') }}"
               class="hidden sm:flex items-center gap-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Artikel Baru
            </a>
        </header>

        {{-- Content Area --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
