<article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col">

    {{-- Thumbnail --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block aspect-video overflow-hidden bg-gradient-to-br from-primary-100 to-wisata-teal/20">
        @if($article->thumbnail)
            <img src="{{ Storage::url($article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-5xl">
                {{ $article->category->icon ?? '🌏' }}
            </div>
        @endif
    </a>

    <div class="p-4 flex-1 flex flex-col">
        {{-- Kategori & Views --}}
        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('articles.search', ['category' => $article->category->slug]) }}"
                class="text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full hover:bg-primary-100 transition-colors">
                {{ $article->category->icon }} {{ $article->category->name }}
            </a>
            <span class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ number_format($article->views) }}
            </span>
        </div>

        {{-- Judul --}}
        <h3 class="font-bold text-gray-800 text-sm leading-snug mb-2 line-clamp-2">
            <a href="{{ route('articles.show', $article->slug) }}"
                class="hover:text-primary-600 transition-colors">
                {{ $article->title }}
            </a>
        </h3>

        {{-- Lokasi --}}
        @if($article->location_name)
            <p class="text-xs text-gray-500 flex items-center gap-1 mt-auto pt-2 border-t border-gray-50">
                <svg class="w-3 h-3 text-wisata-teal flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $article->location_name }}
            </p>
        @endif
    </div>
</article>
