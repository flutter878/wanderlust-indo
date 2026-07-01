<x-app-layout>
    <x-slot name="title">{{ $article->title }} — Wanderlust</x-slot>
    <x-slot name="description">{{ Str::limit(strip_tags($article->content), 160) }}</x-slot>

    {{-- ══════════════════════════════════════════════════════════════
         HERO — Thumbnail fullwidth dengan overlay
    ══════════════════════════════════════════════════════════════ --}}
    <div class="relative w-full h-[55vh] min-h-[360px] overflow-hidden">
        @if($article->thumbnail)
            <img src="{{ Storage::url($article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-sky-200 to-sky-400 flex items-center justify-center">
                <span class="text-9xl opacity-40">{{ $article->category->icon ?? '🌏' }}</span>
            </div>
        @endif
        {{-- Gradient overlay bawah --}}
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-black/20"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            {{-- ═══ KOLOM UTAMA (2/3) ═══ --}}
            <div class="lg:col-span-2">

                {{-- Article Header --}}
                <div class="pt-6 pb-8 border-b border-gray-100">
                    {{-- Breadcrumb --}}
                    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-4">
                        <a href="{{ route('home') }}" class="hover:text-sky-500 transition-colors">Home</a>
                        <span>/</span>
                        <a href="{{ route('articles.search', ['category' => $article->category->slug]) }}"
                           class="hover:text-sky-500 transition-colors">{{ $article->category->name }}</a>
                    </nav>

                    {{-- Title --}}
                    <h1 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-5">
                        {{ $article->title }}
                    </h1>

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-sky-100 flex items-center justify-center text-xs font-bold text-sky-700">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-700">By {{ $article->user->name }}</span>
                        </div>
                        <span>·</span>
                        <span>{{ $article->created_at->translatedFormat('F d, Y') }}</span>
                        <span>·</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ max(1, ceil(str_word_count(strip_tags($article->content)) / 200)) }} min read
                        </span>

                        {{-- Tombol Favorit --}}
                        @auth
                            <form action="{{ route('favorites.toggle', $article) }}" method="POST" class="ml-auto">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full transition-colors border
                                        {{ $isFavorited ? 'bg-red-50 border-red-200 text-red-500' : 'border-gray-200 text-gray-500 hover:border-red-200 hover:text-red-400' }}">
                                    <svg class="w-4 h-4" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ $isFavorited ? 'Saved' : 'Save' }}
                                </button>
                            </form>
                        @else
                            <button onclick="document.getElementById('modal-login').classList.remove('hidden')"
                                class="ml-auto flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:border-red-200 hover:text-red-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Save
                            </button>
                        @endauth
                    </div>
                </div>

                {{-- Article Body --}}
                <div class="py-8">
                    <div class="prose prose-lg max-w-none
                        prose-headings:font-display prose-headings:text-gray-900
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-a:text-sky-600 prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-md
                        prose-strong:text-gray-800
                        prose-blockquote:border-l-sky-400 prose-blockquote:text-gray-500 prose-blockquote:italic">
                        {!! $article->content !!}
                    </div>
                </div>

                {{-- Image Gallery --}}
                @if($article->image_gallery && count($article->image_gallery))
                    <div class="mb-10">
                        <h3 class="font-display font-bold text-xl text-gray-900 mb-4">Photo Gallery</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($article->image_gallery as $image)
                                <img src="{{ Storage::url($image) }}"
                                     alt="Gallery"
                                     class="w-full aspect-square object-cover rounded-xl hover:opacity-90 transition-opacity cursor-pointer">
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Map --}}
                @if($article->map_embed)
                    <div class="mb-10">
                        <h3 class="font-display font-bold text-xl text-gray-900 mb-4">Location</h3>
                        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm aspect-video">
                            {!! $article->map_embed !!}
                        </div>
                    </div>
                @elseif($article->latitude && $article->longitude)
                    <div class="mb-10">
                        <h3 class="font-display font-bold text-xl text-gray-900 mb-4">Location</h3>
                        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm aspect-video">
                            <iframe src="https://maps.google.com/maps?q={{ $article->latitude }},{{ $article->longitude }}&z=14&output=embed"
                                    width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe>
                        </div>
                    </div>
                @endif

                {{-- ══ COMMENTS ══ --}}
                <div class="border-t border-gray-100 pt-10" id="komentar">
                    <h3 class="font-display font-bold text-2xl text-gray-900 mb-6">
                        Comments
                        <span class="text-gray-400 font-sans font-normal text-base ml-1">({{ $article->comments->count() }})</span>
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 border border-green-100 px-4 py-3 rounded-xl mb-5 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    @auth
                        <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-8">
                            @csrf
                            <div class="flex gap-3">
                                <div class="w-9 h-9 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-sm flex-shrink-0 mt-1">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <textarea name="body" rows="3"
                                        placeholder="Share your experience or thoughts..."
                                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent resize-none transition">{{ old('body') }}</textarea>
                                    @error('body')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <button type="submit"
                                        class="mt-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-colors">
                                        Post Comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-8 mb-8 text-center">
                            <p class="text-gray-500 text-sm mb-4">Please Login to Comment</p>
                            <button onclick="document.getElementById('modal-login').classList.remove('hidden')"
                                class="bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-6 py-2.5 rounded-full transition-colors">
                                Login to Comment
                            </button>
                        </div>
                    @endauth

                    {{-- Comments list --}}
                    <div class="space-y-6">
                        @forelse($article->comments as $comment)
                            <div class="flex gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 bg-gray-50 rounded-2xl px-4 py-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                            @auth
                                                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                          onsubmit="return confirm('Delete this comment?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-400 hover:text-red-600">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $comment->body }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <p class="text-sm">No comments yet. Be the first!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ═══ SIDEBAR (1/3) ═══ --}}
            <div class="mt-8 lg:mt-0 space-y-6 lg:pt-6">

                {{-- Location Card --}}
                @if($article->location_name || $article->latitude)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    {{-- Mini map thumbnail --}}
                    @if($article->latitude && $article->longitude)
                        <div class="h-36 overflow-hidden">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $article->latitude }},{{ $article->longitude }}&zoom=10&size=400x200&maptype=roadmap&key="
                                 alt="Map"
                                 class="w-full h-full object-cover"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gray-100 flex items-center justify-center text-3xl\'>🗺️</div>'">
                        </div>
                    @else
                        <div class="h-36 bg-sky-50 flex items-center justify-center">
                            <svg class="w-10 h-10 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">📍 Location</p>
                        @if($article->location_name)
                            <p class="text-sm font-semibold text-gray-800">{{ $article->location_name }}</p>
                        @endif
                        @if($article->latitude && $article->longitude)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $article->latitude }}, {{ $article->longitude }}</p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Article Info --}}
                @if($article->ticket_price_info || $article->operating_hours)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Travel Info</h3>
                    <dl class="space-y-3">
                        @if($article->ticket_price_info)
                            <div>
                                <dt class="text-xs text-gray-400 mb-0.5">🎟 Ticket Price</dt>
                                <dd class="text-sm font-medium text-gray-800">{{ $article->ticket_price_info }}</dd>
                            </div>
                        @endif
                        @if($article->operating_hours)
                            <div>
                                <dt class="text-xs text-gray-400 mb-0.5">🕐 Hours</dt>
                                <dd class="text-sm font-medium text-gray-800">{{ $article->operating_hours }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
                @endif

                {{-- Related Stories --}}
                @if($relatedArticles->count())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Related Stories</h3>
                    <div class="space-y-4">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('articles.show', $related->slug) }}" class="flex gap-3 group">
                                <div class="w-16 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($related->thumbnail)
                                        <img src="{{ Storage::url($related->thumbnail) }}"
                                             alt="{{ $related->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xl">{{ $related->category->icon }}</div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 group-hover:text-sky-600 line-clamp-2 transition-colors leading-snug">
                                        {{ $related->title }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ number_format($related->views) }} views</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Modal Login --}}
    <div id="modal-login" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-7 relative">
            <button onclick="document.getElementById('modal-login').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-lg w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100">✕</button>
            <h3 class="font-display font-bold text-xl text-gray-900 mb-1">Join Wanderlust</h3>
            <p class="text-sm text-gray-500 mb-6">Sign in to save articles and write comments.</p>
            <div class="flex gap-3">
                <a href="{{ route('login') }}"
                   class="flex-1 text-center bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-full text-sm transition-colors">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="flex-1 text-center border border-gray-200 hover:border-sky-300 text-gray-700 font-semibold py-3 rounded-full text-sm transition-colors">
                    Sign Up
                </a>
            </div>
        </div>
    </div>

</x-app-layout>
