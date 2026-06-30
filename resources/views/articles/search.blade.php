<x-app-layout>
    <x-slot name="title">
        @if($query)
            Hasil pencarian "{{ $query }}" — Artikel Wisata
        @elseif($activeCategory)
            Kategori {{ $activeCategory->name }} — Artikel Wisata
        @else
            Semua Artikel Wisata
        @endif
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ══ Header & Filter Bar ══ --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                @if($query)
                    Hasil untuk "<span class="text-primary-600">{{ $query }}</span>"
                @elseif($activeCategory)
                    {{ $activeCategory->icon }} {{ $activeCategory->name }}
                @else
                    🗺️ Semua Artikel Wisata
                @endif
            </h1>

            <form action="{{ route('articles.search') }}" method="GET"
                class="flex flex-wrap gap-3 items-end bg-white border border-gray-200 rounded-xl p-4 shadow-sm">

                {{-- Kolom pencarian --}}
                <div class="flex-1 min-w-52">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kata Kunci</label>
                    <input type="text" name="q" value="{{ $query }}"
                        placeholder="Cari destinasi, misal: Bali..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                </div>

                {{-- Filter kategori --}}
                <div class="min-w-40">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                    <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }} ({{ $cat->articles_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sorting --}}
                <div class="min-w-36">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Urutkan</label>
                    <select name="sort"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Filter
                </button>

                @if($query || $categorySlug)
                    <a href="{{ route('articles.search') }}"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ══ Hasil ══ --}}
        @if($articles->count())
            <p class="text-sm text-gray-500 mb-4">
                Menampilkan {{ $articles->firstItem() }}–{{ $articles->lastItem() }} dari {{ $articles->total() }} artikel
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-8">
                @foreach($articles as $article)
                    @include('partials.article-card', ['article' => $article])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-20 text-gray-400">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada artikel ditemukan</h3>
                <p class="text-sm mb-5">
                    @if($query)
                        Coba kata kunci lain atau hapus filter kategori.
                    @else
                        Belum ada artikel di kategori ini.
                    @endif
                </p>
                <a href="{{ route('home') }}"
                    class="inline-block bg-primary-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-primary-700 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
