<x-app-layout>
    <x-slot name="title">Wanderlust — Discover Your Next Adventure</x-slot>

    {{-- ══════════════════════════════════════════════════════════════
         HERO FULLSCREEN
    ══════════════════════════════════════════════════════════════ --}}
    <section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">

        {{-- Background Image — ambil dari artikel pertama atau fallback --}}
        @if($popularArticles->first()?->thumbnail)
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                 style="background-image: url('{{ Storage::url($popularArticles->first()->thumbnail) }}')"></div>
        @else
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                 style="background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80')"></div>
        @endif

        {{-- Overlay gradient --}}
        <div class="absolute inset-0 hero-overlay"></div>

        {{-- Content --}}
        <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
            <p class="text-white/70 text-sm font-medium tracking-widest uppercase mb-4">Travel Magazine</p>
            <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                Discover your<br>next adventure
            </h1>

            {{-- Search Bar --}}
            <form action="{{ route('articles.search') }}" method="GET"
                  class="flex max-w-xl mx-auto bg-white/10 backdrop-blur-md border border-white/20 rounded-full overflow-hidden shadow-2xl mt-8">
                <div class="flex items-center flex-1 pl-5">
                    <svg class="w-4 h-4 text-white/60 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q"
                           placeholder="Search destinations, experiences..."
                           class="flex-1 bg-transparent text-white placeholder-white/50 text-sm py-4 focus:outline-none">
                </div>
                <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm px-6 py-4 rounded-full m-1 transition-colors">
                    Search
                </button>
            </form>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 animate-bounce">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         FEATURED STORIES — Artikel Terpopuler
    ══════════════════════════════════════════════════════════════ --}}
    @if($popularArticles->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-sky-500 text-xs font-semibold tracking-widest uppercase mb-2">Featured Stories</p>
                <h2 class="font-display text-3xl font-bold text-gray-900">Latest Curated Travelogues</h2>
            </div>
            <a href="{{ route('articles.search', ['sort' => 'popular']) }}"
               class="hidden sm:flex items-center gap-1.5 text-sm font-medium text-sky-600 hover:text-sky-700 transition-colors">
                View all articles
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($popularArticles as $article)
                @include('partials.article-card', ['article' => $article])
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ARTIKEL CAROUSEL — Rekomendasi Berganti Otomatis
    ══════════════════════════════════════════════════════════════ --}}
    @if($popularArticles->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">

        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-sky-500 text-xs font-semibold tracking-widest uppercase mb-2">Editor's Pick</p>
                <h2 class="font-display text-3xl font-bold text-gray-900">Recommended For You</h2>
            </div>
            {{-- Dot indicators + nav --}}
        </div>

        {{-- Carousel container --}}
        <div
            x-data="{
                current: 0,
                total: {{ $popularArticles->count() }},
                autoplay: null,
                paused: false,
                next() { this.current = (this.current + 1) % this.total },
                prev() { this.current = (this.current - 1 + this.total) % this.total },
                goTo(i) { this.current = i },
                startAutoplay() {
                    this.autoplay = setInterval(() => {
                        if (!this.paused) this.next()
                    }, 4000)
                }
            }"
            x-init="startAutoplay()"
            @mouseenter="paused = true"
            @mouseleave="paused = false"
            class="relative rounded-3xl overflow-hidden shadow-xl bg-gray-900"
            style="min-height: 420px;">

            {{-- Slides --}}
            @foreach($popularArticles as $i => $article)
            <div
                x-show="current === {{ $i }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0"
                style="display: none;">

                {{-- Background foto --}}
                <div class="absolute inset-0">
                    @if($article->thumbnail)
                        <img src="{{ Storage::url($article->thumbnail) }}"
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-sky-800 to-sky-950 flex items-center justify-center">
                            <span class="text-8xl opacity-20">{{ $article->category->icon ?? '🌏' }}</span>
                        </div>
                    @endif
                    {{-- Gradient overlay kiri & bawah --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>

                {{-- Konten slide --}}
                <div class="relative z-10 flex flex-col justify-end h-full p-8 lg:p-12" style="min-height: 420px;">
                    <div class="max-w-xl">
                        {{-- Nomor & kategori --}}
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-white/40 font-mono text-xs">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($popularArticles->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="w-px h-3 bg-white/30"></span>
                            <span class="text-sky-400 text-xs font-semibold tracking-widest uppercase">
                                {{ $article->category->name }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h3 class="font-display text-3xl lg:text-4xl font-bold text-white leading-tight mb-3">
                            {{ $article->title }}
                        </h3>

                        {{-- Lokasi & views --}}
                        <div class="flex items-center gap-4 text-white/60 text-sm mb-6">
                            @if($article->location_name)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $article->location_name }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($article->views) }} views
                            </span>
                        </div>

                        {{-- Tombol --}}
                        <a href="{{ route('articles.show', $article->slug) }}"
                           class="inline-flex items-center gap-2 bg-white text-gray-900 hover:bg-sky-50 font-semibold text-sm px-6 py-3 rounded-full transition-colors shadow-lg">
                            Read Article
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Progress bar otomatis --}}
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-white/10 z-20">
                <div class="h-full bg-sky-400 transition-none"
                     x-bind:style="'width:' + ((current + 1) / total * 100) + '%'"
                     style="transition: width 4s linear;"></div>
            </div>

            {{-- Tombol prev / next --}}
            <button @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-sm text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-sm text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Dot indicators --}}
            <div class="absolute bottom-5 right-8 z-20 flex items-center gap-2">
                @foreach($popularArticles as $i => $article)
                    <button @click="goTo({{ $i }})"
                            class="transition-all duration-300 rounded-full"
                            :class="current === {{ $i }}
                                ? 'w-6 h-2 bg-white'
                                : 'w-2 h-2 bg-white/40 hover:bg-white/70'">
                    </button>
                @endforeach
            </div>

            {{-- Thumbnail strip (desktop) --}}
            <div class="absolute right-6 top-1/2 -translate-y-1/2 z-20 hidden xl:flex flex-col gap-2">
                @foreach($popularArticles as $i => $article)
                    @if($article->thumbnail)
                        <button @click="goTo({{ $i }})"
                                class="w-14 h-10 rounded-lg overflow-hidden transition-all duration-300 ring-2"
                                :class="current === {{ $i }} ? 'ring-white scale-110' : 'ring-transparent opacity-50 hover:opacity-80'">
                            <img src="{{ Storage::url($article->thumbnail) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover">
                        </button>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         LATEST ARTICLES
    ══════════════════════════════════════════════════════════════ --}}
    @if($latestArticles->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-sky-500 text-xs font-semibold tracking-widest uppercase mb-2">Fresh Content</p>
                <h2 class="font-display text-3xl font-bold text-gray-900">Recently Published</h2>
            </div>
            <a href="{{ route('articles.search') }}"
               class="hidden sm:flex items-center gap-1.5 text-sm font-medium text-sky-600 hover:text-sky-700 transition-colors">
                View all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($latestArticles as $article)
                @include('partials.article-card', ['article' => $article])
            @endforeach
        </div>
    </section>
    @endif

</x-app-layout>
