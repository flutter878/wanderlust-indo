<x-admin-layout>
    <x-slot name="title">Kelola Kategori</x-slot>

    <div class="max-w-4xl">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Kategori Wisata</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $categories->count() }} kategori terdaftar</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ── Form Tambah Kategori ─────────────────────────────────────── --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Tambah Kategori Baru</h3>

                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-600 mb-1">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name') }}" required
                                   placeholder="Contoh: Wisata Bahari"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500
                                          @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="icon" class="block text-xs font-medium text-gray-600 mb-1">Ikon (Emoji)</label>
                            <input type="text" name="icon" id="icon"
                                   value="{{ old('icon') }}"
                                   placeholder="🏖️"
                                   maxlength="10"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                            <p class="mt-1 text-xs text-gray-400">Opsional, maks. 1 emoji</p>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-medium text-gray-600 mb-1">Deskripsi</label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Deskripsi singkat kategori ini…"
                                      class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium py-2 rounded-lg transition-colors">
                            + Tambah Kategori
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Tabel Kategori ───────────────────────────────────────────── --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Artikel</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors" id="row-{{ $category->id }}">
                                    {{-- Mode tampil normal --}}
                                    <td class="px-5 py-3" id="view-{{ $category->id }}">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg">{{ $category->icon ?? '📁' }}</span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $category->name }}</p>
                                                @if($category->description)
                                                    <p class="text-xs text-gray-400 mt-0.5 max-w-[180px] truncate">{{ $category->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Mode edit inline --}}
                                    <td class="px-5 py-3 hidden" id="edit-{{ $category->id }}" colspan="3">
                                        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="flex flex-wrap items-center gap-2">
                                                <input type="text" name="icon"
                                                       value="{{ $category->icon }}"
                                                       placeholder="🏖️" maxlength="10"
                                                       class="w-14 rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                                                <input type="text" name="name"
                                                       value="{{ $category->name }}"
                                                       required
                                                       class="flex-1 min-w-[120px] rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                                                <input type="text" name="description"
                                                       value="{{ $category->description }}"
                                                       placeholder="Deskripsi"
                                                       class="flex-1 min-w-[120px] rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                                                <button type="submit"
                                                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-colors">
                                                    Simpan
                                                </button>
                                                <button type="button"
                                                        onclick="toggleEdit({{ $category->id }}, false)"
                                                        class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </td>

                                    <td class="px-5 py-3 text-center" id="count-{{ $category->id }}">
                                        <span class="inline-flex items-center text-xs font-medium text-gray-600 bg-gray-100 px-2 py-0.5 rounded-full">
                                            {{ $category->articles_count }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-3 text-right" id="actions-{{ $category->id }}">
                                        <div class="flex items-center justify-end gap-2">
                                            {{-- Edit --}}
                                            <button type="button"
                                                    onclick="toggleEdit({{ $category->id }}, true)"
                                                    class="p-1.5 text-blue-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                    title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                                  onsubmit="return confirm('Hapus kategori "{{ addslashes($category->name) }}"?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Hapus"
                                                        {{ $category->articles_count > 0 ? 'disabled title=Masih ada artikel' : '' }}>
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
                                    <td colspan="3" class="px-5 py-10 text-center text-sm text-gray-400">
                                        Belum ada kategori. Tambahkan di form sebelah kiri.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->isEmpty() === false)
                    <p class="mt-2 text-xs text-gray-400 px-1">
                        💡 Kategori yang masih memiliki artikel tidak dapat dihapus.
                    </p>
                @endif
            </div>
        </div>

    </div>

</x-admin-layout>

@push('scripts')
<script>
    /**
     * Toggle mode edit inline pada baris kategori.
     */
    function toggleEdit(id, show) {
        const view    = document.getElementById('view-' + id);
        const editRow = document.getElementById('edit-' + id);
        const count   = document.getElementById('count-' + id);
        const actions = document.getElementById('actions-' + id);

        if (show) {
            view?.classList.add('hidden');
            count?.classList.add('hidden');
            actions?.classList.add('hidden');
            editRow?.classList.remove('hidden');
        } else {
            view?.classList.remove('hidden');
            count?.classList.remove('hidden');
            actions?.classList.remove('hidden');
            editRow?.classList.add('hidden');
        }
    }
</script>
@endpush
