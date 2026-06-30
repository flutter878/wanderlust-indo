<x-app-layout>
    <x-slot name="title">Favorit Saya — Artikel Wisata</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">❤️ Favorit Saya</h1>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($favorites->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-8">
                @foreach($favorites as $favorite)
                    @include('partials.article-card', ['article' => $favorite->article])
                @endforeach
            </div>
            <div class="flex justify-center">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-20 text-gray-400">
                <div class="text-6xl mb-4">💔</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada artikel favorit</h3>
                <p class="text-sm mb-5">Mulai jelajahi dan simpan artikel wisata yang kamu suka.</p>
                <a href="{{ route('home') }}"
                    class="inline-block bg-primary-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-primary-700 transition-colors">
                    Jelajahi Sekarang
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
