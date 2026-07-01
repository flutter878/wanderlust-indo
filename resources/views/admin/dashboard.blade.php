<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- ══ Stat Cards ══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">📝</span>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                    {{ $stats['published'] }} publish
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_articles'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Artikel</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">💬</span>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_comments']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Komentar</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">👥</span>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Pengguna Terdaftar</p>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">👁️</span>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_views']) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Views</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ══ Artikel Terbaru ══ --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Artikel Terbaru</h2>
                <a href="{{ route('admin.articles.index') }}" class="text-xs text-primary-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentArticles as $article)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-lg flex-shrink-0">
                            {{ $article->category->icon ?? '📄' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $article->title }}</p>
                            <p class="text-xs text-gray-400">{{ $article->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0
                            {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $article->status === 'published' ? 'Publish' : 'Draft' }}
                        </span>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Belum ada artikel.</p>
                @endforelse
            </div>
        </div>

        {{-- ══ Top Artikel ══ --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">🔥 Artikel Terpopuler</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($topArticles as $i => $article)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <span class="text-lg font-bold text-gray-300 w-6 text-center flex-shrink-0">{{ $i + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $article->title }}</p>
                            <p class="text-xs text-gray-400">{{ number_format($article->views) }} views</p>
                        </div>
                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                            class="text-xs text-primary-600 hover:underline flex-shrink-0">Lihat</a>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        {{-- ══ Komentar Terbaru ══ --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Komentar Terbaru</h2>
                <a href="{{ route('admin.comments.index') }}" class="text-xs text-primary-600 hover:underline">Moderasi</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentComments as $comment)
                    <div class="flex items-start gap-3 px-5 py-3">
                        <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 flex-shrink-0 mt-0.5">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs font-semibold text-gray-700">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">di</span>
                                <span class="text-xs text-primary-600 truncate max-w-40">{{ $comment->article->title }}</span>
                                <span class="text-xs text-gray-400 ml-auto flex-shrink-0">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-1">{{ $comment->body }}</p>
                        </div>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                            onsubmit="return confirm('Hapus komentar ini?')" class="flex-shrink-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Belum ada komentar.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-admin-layout>
