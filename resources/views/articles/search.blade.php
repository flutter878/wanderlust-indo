<x-app-layout>
    <x-slot name="title">
        @if($query) Search "{{ $query }}" @elseif($activeCategory) {{ $activeCategory->name }} @else Explore Articles @endif — Wanderlust
    </x-slot>

    {{-- ══ HEADER BLOK ══════════════════════════════════════════════════════════ --}}
    <div class="bg-gray-50 border-b border-gray-100 pt-20 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul --}}
            <h1 class="font-display text-3xl font-bold text-gray-900 leading-tight mb-0.5">
                @if($query)
                    Results for "<span class="text-sky-500">{{ $query }}</span>"
                @elseif($activeCategory)
                    {{ $activeCategory->name }}
                @else
                    Explore Articles
                @endif
            </h1>
            <p class="text-gray-400 text-sm mb-4">
                @if($activeCategory?->description) {{ $activeCategory->description }}
                @else Discover places, stories, and adventures
                @endif
            </p>

            {{-- ── Satu form: search + pills + sort + clear semuanya inline ── --}}
            <form action="{{ route('articles.search') }}" method="GET">

                {{-- Baris filter --}}
                <div class="flex flex-wrap items-center gap-2">

                    {{-- Search --}}
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="q" value="{{ $query }}"
                               placeholder="Search destinations..."
                               class="bg-white border border-gray-200 rounded-full pl-11 pr-5 py-2 text-sm w-56
                                      focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent
                                      focus:w-72 transition-all duration-200 shadow-sm">
                        @if($categorySlug)
                            <input type="hidden" name="category" value="{{ $categorySlug }}">
                        @endif
                    </div>

                    <span class="w-px h-5 bg-gray-200 hidden sm:block"></span>

                    {{-- All --}}
                    <button type="submit"
                            onclick="this.form.querySelector('[name=category]') && this.form.querySelector('[name=category]').remove()"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 min-w-[72px] rounded-full text-xs font-semibold border transition-all shadow-sm
                                   {{ !$categorySlug ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-500 border-gray-200 hover:border-gray-400 hover:text-gray-700' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        All
                        <span class="{{ !$categorySlug ? 'text-white/60' : 'text-gray-400' }} font-normal">{{ $categories->sum('articles_count') }}</span>
                    </button>

                    {{-- Category pills --}}
                    @foreach($categories as $cat)
                        @php
                            $isActive = $categorySlug === $cat->slug;
                            $cm = match($cat->slug) {
                                'pantai'  => ['a'=>'bg-sky-500 text-white border-sky-500',      'h'=>'hover:border-sky-300 hover:text-sky-600',      'i'=>'text-sky-400'],
                                'gunung'  => ['a'=>'bg-emerald-500 text-white border-emerald-500','h'=>'hover:border-emerald-300 hover:text-emerald-600','i'=>'text-emerald-400'],
                                'sejarah' => ['a'=>'bg-amber-500 text-white border-amber-500',   'h'=>'hover:border-amber-300 hover:text-amber-600',   'i'=>'text-amber-400'],
                                'kuliner' => ['a'=>'bg-orange-500 text-white border-orange-500', 'h'=>'hover:border-orange-300 hover:text-orange-600', 'i'=>'text-orange-400'],
                                'alam'    => ['a'=>'bg-green-500 text-white border-green-500',   'h'=>'hover:border-green-300 hover:text-green-600',   'i'=>'text-green-400'],
                                'kota'    => ['a'=>'bg-violet-500 text-white border-violet-500', 'h'=>'hover:border-violet-300 hover:text-violet-600', 'i'=>'text-violet-400'],
                                default   => ['a'=>'bg-sky-500 text-white border-sky-500',      'h'=>'hover:border-sky-300 hover:text-sky-600',      'i'=>'text-sky-400'],
                            };
                            $icons = [
                                'pantai'  => 'M12 3v1m6.364 1.636l-.707.707M21 12h-1M18.364 18.364l-.707-.707M12 21v-1m-6.364-1.636l.707-.707M4 12H3m3.343-5.657l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z',
                                'gunung'  => 'M3 17l4-8 4 5 3-3 5 6H3z',
                                'sejarah' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                                'kuliner' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                                'alam'    => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                                'kota'    => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            ];
                            $d = $icons[$cat->slug] ?? 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z';
                        @endphp
                        <button type="submit" name="category" value="{{ $cat->slug }}"
                                class="inline-flex items-center justify-center gap-2 px-5 py-2 min-w-[90px] rounded-full text-xs font-semibold border transition-all shadow-sm
                                       {{ $isActive ? $cm['a'] : 'bg-white text-gray-500 border-gray-200 '.$cm['h'] }}">
                            <svg class="w-3.5 h-3.5 flex-shrink-0 {{ $isActive ? 'text-white' : $cm['i'] }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $d }}"/>
                            </svg>
                            {{ $cat->name }}
                            <span class="{{ $isActive ? 'text-white/60' : 'text-gray-400' }} font-normal">{{ $cat->articles_count }}</span>
                        </button>
                    @endforeach

                    <span class="w-px h-5 bg-gray-200 hidden sm:block"></span>

                    {{-- Sort --}}
                    <select name="sort" onchange="this.form.submit()"
                            class="bg-white border border-gray-200 rounded-full px-3 py-1.5 text-xs font-medium text-gray-600
                                   focus:outline-none focus:ring-2 focus:ring-sky-300 transition shadow-sm cursor-pointer">
                        <option value="latest"  {{ $sort === 'latest'  ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Popular</option>
                    </select>

                    {{-- Clear --}}
                    @if($query || $categorySlug)
                        <a href="{{ route('articles.search') }}"
                           class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-xs text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear
                        </a>
                    @endif

                </div>
            </form>

        </div>
    </div>

    {{-- ══ KONTEN ════════════════════════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        @if($articles->count())
            <p class="text-xs text-gray-400 mb-5">
                Showing <span class="font-medium text-gray-600">{{ $articles->firstItem() }}–{{ $articles->lastItem() }}</span>
                of <span class="font-medium text-gray-600">{{ $articles->total() }}</span> articles
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-10">
                @foreach($articles as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $articles->links() }}
            </div>

        @else
            <div class="text-center py-20">
                <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-700 mb-2">No articles found</h3>
                <p class="text-sm text-gray-400 mb-6">
                    @if($query) Try a different keyword or remove the filter.
                    @else No articles in this category yet. @endif
                </p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-colors">
                    Back to Home
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
