<article class="group relative rounded-2xl overflow-hidden bg-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer">

    {{-- Thumbnail wrapper --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block aspect-[335/376] relative overflow-hidden">
        @if($article->thumbnail)
            <img src="{{ Storage::url($article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center">
                <span class="text-6xl opacity-50">{{ $article->category->icon ?? '🌏' }}</span>
            </div>
        @endif

        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

        {{-- Category pill — top left --}}
        <div class="absolute top-3 left-3">
            <span class="inline-flex items-center gap-1 bg-sky-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full shadow">
                {{ $article->category->name }}
            </span>
        </div>

        {{-- Views — top right --}}
        <div class="absolute top-3 right-3">
            <span class="flex items-center gap-1 bg-black/30 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ number_format($article->views) }}
            </span>
        </div>

        {{-- Bottom info overlay --}}
        <div class="absolute bottom-0 left-0 right-0 p-4">
            {{-- Location --}}
            @if($article->location_name)
                <div class="flex items-center gap-1 text-white/70 text-xs mb-1.5">
                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <span class="truncate">{{ $article->location_name }}</span>
                </div>
            @endif

            {{-- Title --}}
            <h3 class="font-display font-bold text-white text-base leading-snug line-clamp-2">
                {{ $article->title }}
            </h3>

            {{-- Date --}}
            <p class="text-white/50 text-xs mt-1.5">{{ $article->created_at->format('d M Y') }}</p>
        </div>
    </a>

</article>
