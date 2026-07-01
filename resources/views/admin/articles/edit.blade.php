<x-admin-layout>
    <x-slot name="title">Edit Artikel</x-slot>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-5">
        <a href="{{ route('admin.articles.index') }}" class="hover:text-primary-600 transition-colors">Artikel</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-800 font-medium truncate max-w-xs">{{ $article->title }}</span>
    </nav>

    <div class="max-w-4xl">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-6">Edit Artikel Wisata</h2>

            <form action="{{ route('admin.articles.update', $article) }}" method="POST"
                  enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- ── Judul ────────────────────────────────────────────────── --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $article->title) }}"
                           required
                           class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500
                                  @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Kategori + Status ────────────────────────────────────── --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori Wisata <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500
                                       @error('category_id') border-red-300 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status Penerbitan <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                            <option value="draft"      {{ old('status', $article->status) === 'draft'      ? 'selected' : '' }}>Draft</option>
                            <option value="published"  {{ old('status', $article->status) === 'published'  ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ── Lokasi + Thumbnail ───────────────────────────────────── --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="location_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lokasi / Daerah
                        </label>
                        <input type="text" name="location_name" id="location_name"
                               value="{{ old('location_name', $article->location_name) }}"
                               placeholder="Contoh: Ubud, Bali"
                               class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                        @error('location_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                        {{-- Preview thumbnail saat ini --}}
                        @if($article->thumbnail)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ Storage::url($article->thumbnail) }}"
                                     alt="Thumbnail" class="w-16 h-12 object-cover rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500">Thumbnail saat ini</p>
                                    <label class="flex items-center gap-1.5 mt-1 cursor-pointer">
                                        <input type="checkbox" name="remove_thumbnail" value="1"
                                               class="rounded border-gray-300 text-red-500 focus:ring-red-400">
                                        <span class="text-xs text-red-500">Hapus thumbnail</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                                      file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700
                                      hover:file:bg-primary-100">
                        <p class="mt-1 text-xs text-gray-400">JPG, PNG, WebP — maks. 2 MB. Kosongkan jika tidak ingin mengganti.</p>
                        @error('thumbnail')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ── Koordinat & Peta ─────────────────────────────────────── --}}
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-sm font-medium text-gray-700 mb-3">📍 Informasi Lokasi (Opsional)</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="latitude" class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                   value="{{ old('latitude', $article->latitude) }}"
                                   placeholder="-8.409518"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('latitude')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitude" class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                   value="{{ old('longitude', $article->longitude) }}"
                                   placeholder="115.188919"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('longitude')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="map_embed" class="block text-xs font-medium text-gray-600 mb-1">Embed Map (iframe)</label>
                            <input type="text" name="map_embed" id="map_embed"
                                   value="{{ old('map_embed', $article->map_embed) }}"
                                   placeholder="&lt;iframe src='...'&gt;&lt;/iframe&gt;"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('map_embed')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Konten ───────────────────────────────────────────────── --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                        Isi Artikel / Deskripsi Wisata <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="12" required
                              class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:ring-primary-500 focus:border-primary-500
                                     @error('content') border-red-300 @enderror">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Tombol Aksi ──────────────────────────────────────────── --}}
                <div class="flex items-center justify-between border-t border-gray-100 pt-5">
                    <a href="{{ route('admin.articles.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                        ← Kembali
                    </a>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                           class="text-sm text-gray-500 hover:text-primary-600 px-4 py-2 rounded-lg border border-gray-200 hover:border-primary-300 transition-colors">
                            Lihat Artikel
                        </a>
                        <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Meta Info --}}
        <div class="mt-4 text-xs text-gray-400 px-1">
            Dibuat: {{ $article->created_at->format('d M Y, H:i') }} &nbsp;·&nbsp;
            Terakhir diperbarui: {{ $article->updated_at->format('d M Y, H:i') }} &nbsp;·&nbsp;
            Slug: <code class="bg-gray-100 px-1 rounded">{{ $article->slug }}</code>
        </div>
    </div>

</x-admin-layout>

@push('scripts')
<script>
    // Inisialisasi TinyMCE
    tinymce.init({
        selector: '#content',
        plugins: 'lists link image code table',
        toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
        menubar: false,
        height: 400,
        language: 'id',
    });
</script>
@endpush
