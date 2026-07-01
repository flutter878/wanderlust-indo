<x-admin-layout>
    <x-slot name="title">Kelola Artikel</x-slot>

    {{-- ── Header + Tombol Tambah ──────────────────────────────────────────── --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Artikel</h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola semua artikel wisata</p>
        </div>
        <a href="{{ route('admin.articles.create') }}"
           class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Artikel
        </a>
    </div>

    {{-- ── Filter & Search ─────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.articles.index') }}"
          class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-5 flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ $query }}" placeholder="Cari judul artikel…"
               class="flex-1 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
        <select name="status"
                class="rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
            <option value="">-- Semua Status --</option>
            <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ $status === 'draft'     ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit"
                class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            Cari
        </button>
        @if($query || $status)
            <a href="{{ route('admin.articles.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                Reset
            </a>
        @endif
    </form>

    {{-- ── Tabel Artikel ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Artikel</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Views</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden xl:table-cell">Dibuat</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 text-sm text-gray-400">
                                {{ $articles->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    {{-- Thumbnail --}}
                                    <div class="w-12 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                        @if($article->thumbnail)
                                            <img src="{{ Storage::url($article->thumbnail) }}"
                                                 alt="{{ $article->title }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate max-w-xs">{{ $article->title }}</p>
                                        @if($article->location_name)
                                            <p class="text-xs text-gray-400 mt-0.5">📍 {{ $article->location_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 hidden md:table-cell">
                                <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                                    {{ $article->category->icon ?? '📄' }}
                                    {{ $article->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 hidden lg:table-cell">
                                <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full
                                    {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-500 hidden lg:table-cell">
                                {{ number_format($article->views) }}
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-400 hidden xl:table-cell">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Lihat Publik --}}
                                    <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                                       title="Lihat"
                                       class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                       title="Edit"
                                       class="p-1.5 text-blue-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                          onsubmit="return confirm('Hapus artikel "{{ addslashes($article->title) }}"? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-sm text-gray-400">
                                @if($query || $status)
                                    Tidak ada artikel yang cocok dengan filter.
                                    <a href="{{ route('admin.articles.index') }}" class="text-primary-600 hover:underline ml-1">Reset filter</a>
                                @else
                                    Belum ada artikel.
                                    <a href="{{ route('admin.articles.create') }}" class="text-primary-600 hover:underline ml-1">Buat artikel pertama</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $articles->links() }}
            </div>
        @endif

        {{-- Footer info --}}
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-400">
            Menampilkan {{ $articles->firstItem() ?? 0 }}–{{ $articles->lastItem() ?? 0 }}
            dari {{ $articles->total() }} artikel
        </div>
    </div>

</x-admin-layout>

@push('scripts')
<script>
    // Konfirmasi sebelum hapus (sudah via onsubmit, ini fallback)
</script>
@endpush
