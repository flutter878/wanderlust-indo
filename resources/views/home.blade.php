<x-app-layout>
    <x-slot name="title">Beranda — Artikel Wisata Nusantara</x-slot>

    {{-- ══════════════════════════════════════════════════════════════
         HERO BANNER
    ══════════════════════════════════════════════════════════════ --}}
    <section class="relative bg-gradient-to-br from-primary-700 via-primary-600 to-wisata-teal overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                Jelajahi Keindahan<br>
                <span class="text-yellow-300">Nusantara</span>
            </h1>
            <p class="text-primary-100 text-lg sm:text-xl max-w-2xl mx-auto mb-8">
                Temukan destinasi wisata terbaik Indonesia — dari pantai eksotis, puncak gunung yang megah, situs bersejarah, hingga kuliner khas daerah.
            </p>

            {{-- Search Bar Hero --}}
            <form action="{{ route('articles.search') }}" method="GET"
                class="flex max-w-xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                <input type="text" name="q" placeholder="Cari destinasi, misal: Bali, Borobudur..."
                    class="flex-1 px-5 py-3.5 text-gray-800 text-sm focus:outline-none border-0">
                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3.5 font-semibold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         FILTER KATEGORI
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-xl font-bold text-gray-800 mb-5">Jelajahi Berdasarkan Kategori</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('articles.search') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-primary-600 text-white text-sm font-medium hover:bg-primary-700 transition-colors">
                🗺️ Semua
            </a>
            @foreach($categories as $category)
                <a href="{{ route('articles.search', ['category' => $category->slug]) }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:border-primary-500 hover:text-primary-600 transition-colors">
                    {{ $category->icon }} {{ $category->name }}
                    @if($category->articles_count > 0)
                        <span class="bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">{{ $category->articles_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ARTIKEL TERPOPULER
    ══════════════════════════════════════════════════════════════ --}}
    @if($popularArticles->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-800">🔥 Paling Populer</h2>
            <a href="{{ route('articles.search', ['sort' => 'popular']) }}"
                class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($popularArticles as $article)
                @include('partials.article-card', ['article' => $article])
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ARTIKEL TERBARU
    ══════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-800">🆕 Artikel Terbaru</h2>
            <a href="{{ route('articles.search') }}"
                class="text-sm text-primary-600 hover:text-primary-700 font-medium">Lihat semua →</a>
        </div>

        @if($latestArticles->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($latestArticles as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-gray-400">
                <div class="text-5xl mb-3">📭</div>
                <p>Belum ada artikel yang dipublikasikan.</p>
            </div>
        @endif
    </section>

</x-app-layout>
