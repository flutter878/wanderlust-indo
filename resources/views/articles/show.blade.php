<x-app-layout>
    <x-slot name="title">{{ $article->title }} — Artikel Wisata</x-slot>
    <x-slot name="description">{{ Str::limit(strip_tags($article->content), 160) }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">

            {{-- ══════════════════════════════════════════════════════
                 KOLOM UTAMA (2/3)
            ══════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-2">

                {{-- Breadcrumb --}}
                <nav class="text-sm text-gray-500 mb-4 flex items-center gap-1.5">
                    <a href="{{ route('home') }}" class="hover:text-primary-600">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('articles.search', ['category' => $article->category->slug]) }}"
                        class="hover:text-primary-600">{{ $article->category->name }}</a>
                    <span>/</span>
                    <span class="text-gray-700 line-clamp-1">{{ Str::limit($article->title, 40) }}</span>
                </nav>

                {{-- Kategori badge --}}
                <a href="{{ route('articles.search', ['category' => $article->category->slug]) }}"
                    class="inline-flex items-center gap-1 text-xs font-semibold text-primary-600 bg-primary-50 px-3 py-1 rounded-full mb-3 hover:bg-primary-100">
                    {{ $article->category->icon }} {{ $article->category->name }}
                </a>

                {{-- Judul --}}
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $article->title }}
                </h1>

                {{-- Meta info --}}
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-100">
                    <span class="flex items-center gap-1.5">
                        <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center text-xs text-primary-700 font-bold">
                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                        </div>
                        {{ $article->user->name }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $article->created_at->translatedFormat('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($article->views) }} kali dilihat
                    </span>

                    {{-- Tombol Favorit --}}
                    @auth
                        <form action="{{ route('favorites.toggle', $article) }}" method="POST" class="ml-auto">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg transition-colors
                                    {{ $isFavorited ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                <svg class="w-4 h-4 {{ $isFavorited ? 'fill-red-500' : '' }}"
                                    fill="{{ $isFavorited ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                {{ $isFavorited ? 'Difavoritkan' : 'Favorit' }}
                            </button>
                        </form>
                    @else
                        <button onclick="document.getElementById('modal-login').classList.remove('hidden')"
                            class="ml-auto flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Favorit
                        </button>
                    @endauth
                </div>

                {{-- Thumbnail utama --}}
                @if($article->thumbnail)
                    <img src="{{ Storage::url($article->thumbnail) }}"
                         alt="{{ $article->title }}"
                         class="w-full rounded-xl mb-6 aspect-video object-cover">
                @else
                    <div class="w-full rounded-xl mb-6 aspect-video bg-gradient-to-br from-primary-100 to-wisata-teal/20 flex items-center justify-center text-8xl">
                        {{ $article->category->icon ?? '🌏' }}
                    </div>
                @endif

                {{-- Konten Artikel --}}
                <div class="prose prose-lg max-w-none text-gray-700 mb-8
                    prose-headings:text-gray-900 prose-a:text-primary-600
                    prose-img:rounded-xl prose-img:shadow-sm">
                    {!! $article->content !!}
                </div>

                {{-- Galeri Foto --}}
                @if($article->image_gallery && count($article->image_gallery))
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">📸 Galeri Foto</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($article->image_gallery as $image)
                                <img src="{{ Storage::url($image) }}"
                                     alt="Galeri {{ $article->title }}"
                                     class="w-full aspect-square object-cover rounded-lg hover:opacity-90 transition-opacity cursor-pointer">
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ══ PETA LOKASI ══ --}}
                @if($article->map_embed)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">🗺️ Lokasi</h3>
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-video">
                            {!! $article->map_embed !!}
                        </div>
                    </div>
                @elseif($article->latitude && $article->longitude)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">🗺️ Lokasi</h3>
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-video">
                            <iframe
                                src="https://maps.google.com/maps?q={{ $article->latitude }},{{ $article->longitude }}&z=14&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy">
                            </iframe>
                        </div>
                    </div>
                @endif

                {{-- ══ KOMENTAR ══ --}}
                <div class="mt-10" id="komentar">
                    <h3 class="text-lg font-bold text-gray-800 mb-5">
                        💬 Komentar ({{ $article->comments->count() }})
                    </h3>

                    {{-- Flash message --}}
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form Komentar --}}
                    @auth
                        <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <textarea name="body" rows="3"
                                        placeholder="Bagikan pengalaman atau pendapat kamu tentang destinasi ini..."
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none">{{ old('body') }}</textarea>
                                    @error('body')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <button type="submit"
                                        class="mt-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6 text-center">
                            <p class="text-gray-600 text-sm mb-3">Masuk untuk menulis komentar</p>
                            <button onclick="document.getElementById('modal-login').classList.remove('hidden')"
                                class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
                                Masuk / Daftar
                            </button>
                        </div>
                    @endauth

                    {{-- Daftar Komentar --}}
                    @forelse($article->comments as $comment)
                        <div class="flex gap-3 mb-5 pb-5 border-b border-gray-100 last:border-0">
                            <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm flex-shrink-0">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        @auth
                                            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                    onsubmit="return confirm('Hapus komentar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600">Hapus</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <div class="text-4xl mb-2">💬</div>
                            <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 SIDEBAR (1/3)
            ══════════════════════════════════════════════════════ --}}
            <div class="mt-8 lg:mt-0 space-y-6">

                {{-- Info Wisata --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide">ℹ️ Info Wisata</h3>
                    <dl class="space-y-3 text-sm">
                        @if($article->location_name)
                            <div>
                                <dt class="text-gray-500 text-xs font-medium mb-0.5">📍 Lokasi</dt>
                                <dd class="text-gray-800 font-medium">{{ $article->location_name }}</dd>
                            </div>
                        @endif
                        @if($article->ticket_price_info)
                            <div>
                                <dt class="text-gray-500 text-xs font-medium mb-0.5">🎟️ Harga Tiket</dt>
                                <dd class="text-gray-800 font-medium">{{ $article->ticket_price_info }}</dd>
                            </div>
                        @endif
                        @if($article->operating_hours)
                            <div>
                                <dt class="text-gray-500 text-xs font-medium mb-0.5">🕐 Jam Operasional</dt>
                                <dd class="text-gray-800 font-medium">{{ $article->operating_hours }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Artikel Terkait --}}
                @if($relatedArticles->count())
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide">🔗 Artikel Terkait</h3>
                        <div class="space-y-4">
                            @foreach($relatedArticles as $related)
                                <a href="{{ route('articles.show', $related->slug) }}"
                                    class="flex gap-3 group">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-primary-50 flex items-center justify-center flex-shrink-0 text-2xl">
                                        @if($related->thumbnail)
                                            <img src="{{ Storage::url($related->thumbnail) }}"
                                                 alt="{{ $related->title }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ $related->category->icon ?? '🌏' }}
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 group-hover:text-primary-600 line-clamp-2 transition-colors">
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

    {{-- ══════════════════════════════════════════════════════
         MODAL LOGIN (untuk guest yang klik favorit/komentar)
    ══════════════════════════════════════════════════════ --}}
    <div id="modal-login" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tertarik berbagi pengalaman?</h3>
            <p class="text-sm text-gray-600 mb-5">
                Silakan masuk log terlebih dahulu menggunakan email Anda untuk menulis komentar atau menyimpan favorit.
            </p>
            <div class="flex gap-3">
                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                    class="flex-1 text-center bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="flex-1 text-center border border-gray-300 hover:border-primary-400 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Daftar
                </a>
            </div>
            <button onclick="document.getElementById('modal-login').classList.add('hidden')"
                class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-xl">✕</button>
        </div>
    </div>

</x-app-layout>
