<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate(['body' => ['required', 'string', 'max:1000']]);

        $article->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function destroy(Comment $comment)
    {
        // Hanya pemilik atau admin yang boleh hapus
        if (auth()->id() !== $comment->user_id && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
