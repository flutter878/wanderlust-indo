<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');

        $comments = Comment::with(['user', 'article'])
            ->when($query, fn($q) => $q->where('body', 'like', "%{$query}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.comments.index', compact('comments', 'query'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
