<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Halaman detail artikel.
     */
    public function show(string $slug)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with(['category', 'user', 'comments.user'])
            ->firstOrFail();

        // Tambah view count
        $article->increment('views');

        // Cek apakah user sudah favoritkan
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('article_id', $article->id)
                ->exists();
        }

        // Artikel terkait (same category, exclude current)
        $relatedArticles = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with('category')
            ->latest()
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'isFavorited', 'relatedArticles'));
    }

    /**
     * Halaman pencarian & filter artikel.
     */
    public function search(Request $request)
    {
        $query      = $request->get('q', '');
        $categorySlug = $request->get('category', '');
        $sort       = $request->get('sort', 'latest'); // latest | popular

        $articlesQuery = Article::published()->with(['category', 'user']);

        // Filter kata kunci
        if ($query) {
            $articlesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('location_name', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            });
        }

        // Filter kategori
        if ($categorySlug) {
            $articlesQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Sorting
        if ($sort === 'popular') {
            $articlesQuery->popular();
        } else {
            $articlesQuery->latest();
        }

        $articles   = $articlesQuery->paginate(12)->withQueryString();
        $categories = Category::withCount(['articles' => fn($q) => $q->where('status', 'published')])->get();
        $activeCategory = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;

        return view('articles.search', compact(
            'articles',
            'categories',
            'query',
            'categorySlug',
            'sort',
            'activeCategory'
        ));
    }
}
