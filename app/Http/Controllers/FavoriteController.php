<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Halaman daftar favorit user.
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with(['article.category'])
            ->orderByDesc('bookmarked_at')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorit (tambah/hapus).
     */
    public function toggle(Article $article)
    {
        $existing = Favorite::where('user_id', auth()->id())
            ->where('article_id', $article->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id'       => auth()->id(),
                'article_id'    => $article->id,
                'bookmarked_at' => now(),
            ]);
            $status = 'added';
        }

        if (request()->wantsJson()) {
            return response()->json(['status' => $status]);
        }

        return back()->with('success',
            $status === 'added' ? 'Artikel ditambahkan ke favorit.' : 'Artikel dihapus dari favorit.'
        );
    }
}
