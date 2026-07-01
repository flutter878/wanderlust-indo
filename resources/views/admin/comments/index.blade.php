<x-admin-layout>
    <x-slot name="title">Moderasi Komentar</x-slot>

    {{-- ── Header ───────────────────────────────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Moderasi Komentar</h2>
            <p class="text-sm text-gray-500 mt-0.5">Tinjau dan kelola komentar pengguna</p>
        </div>
    </div>

    {{-- ── Search ────────────────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.comments.index') }}"
          class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5 flex gap-3">
        <input type="text" name="q" value="{{ $query }}" placeholder="Cari isi komentar…"
               class="flex-1 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
        <button type="submit"
                class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            Cari
        </button>
        @if($query)
            <a href="{{ route('admin.comments.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                Reset
            </a>
        @endif
    </form>

    {{-- ── Daftar Komentar ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

        @forelse($comments as $comment)
            <div class="flex items-start gap-4 px-5 py-4 {{ !$loop->last ? 'border-b border-gray-50' : '' }} hover:bg-gray-50/60 transition-colors group">

                {{-- Avatar --}}
                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-sm font-bold text-primary-700 flex-shrink-0">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>

                {{-- Konten --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-1">
                        <span class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-400">berkomentar di</span>
                        <a href="{{ route('articles.show', $comment->article->slug) }}" target="_blank"
                           class="text-xs text-primary-600 hover:underline font-medium max-w-[200px] truncate">
                            {{ $comment->article->title }}
                        </a>
                        <span class="text-xs text-gray-400 ml-auto">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->format('d M Y, H:i') }}</p>
                </div>

                {{-- Tombol Hapus --}}
                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                      onsubmit="return confirm('Hapus komentar dari {{ addslashes($comment->user->name) }}?')"
                      class="flex-shrink-0">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-1 text-xs text-red-400 hover:text-red-600 hover:bg-red-50 px-2.5 py-1.5 rounded-lg transition-colors
                                   opacity-0 group-hover:opacity-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        @empty
            <div class="px-5 py-16 text-center">
                <div class="text-4xl mb-3">💬</div>
                <p class="text-sm text-gray-500">
                    @if($query)
                        Tidak ada komentar yang cocok dengan pencarian.
                        <a href="{{ route('admin.comments.index') }}" class="text-primary-600 hover:underline">Reset</a>
                    @else
                        Belum ada komentar.
                    @endif
                </p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($comments->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $comments->links() }}
            </div>
        @endif

        {{-- Footer info --}}
        @if($comments->total() > 0)
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-400">
                Menampilkan {{ $comments->firstItem() }}–{{ $comments->lastItem() }}
                dari {{ $comments->total() }} komentar
            </div>
        @endif
    </div>

</x-admin-layout>
