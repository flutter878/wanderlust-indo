<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query  = $request->get('q', '');
        $status = $request->get('status', '');

        $articles = Article::with('category')
            ->when($query, fn($q) => $q->where('title', 'like', "%{$query}%"))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', compact('articles', 'query', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'category_id'   => ['required', 'exists:categories,id'],
            'content'       => ['required', 'string'],
            'thumbnail'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'map_embed'     => ['nullable', 'string'],
            'latitude'      => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'     => ['nullable', 'numeric', 'between:-180,180'],
            'status'        => ['required', 'in:draft,published'],
        ]);

        $slug = $this->generateUniqueSlug($validated['title']);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        Article::create(array_merge($validated, [
            'user_id'   => auth()->id(),
            'slug'      => $slug,
            'thumbnail' => $thumbnailPath,
        ]));

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel "' . $validated['title'] . '" berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'category_id'   => ['required', 'exists:categories,id'],
            'content'       => ['required', 'string'],
            'thumbnail'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'map_embed'     => ['nullable', 'string'],
            'latitude'      => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'     => ['nullable', 'numeric', 'between:-180,180'],
            'status'        => ['required', 'in:draft,published'],
        ]);

        // Update slug hanya jika judul berubah
        if ($article->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $article->id);
        }

        // Upload thumbnail baru, hapus yang lama
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        // Hapus thumbnail jika dicentang
        if ($request->boolean('remove_thumbnail') && $article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
            $validated['thumbnail'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel "' . $article->title . '" berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug  = Str::slug($title);
        $query = Article::where('slug', 'like', $slug . '%');
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        $count = $query->count();
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}
