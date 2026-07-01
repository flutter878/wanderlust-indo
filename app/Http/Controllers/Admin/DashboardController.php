<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles'    => Article::count(),
            'published'         => Article::where('status', 'published')->count(),
            'draft'             => Article::where('status', 'draft')->count(),
            'total_comments'    => Comment::count(),
            'total_users'       => User::where('role', 'user')->count(),
            'total_categories'  => Category::count(),
            'total_views'       => Article::sum('views'),
        ];

        // 5 artikel terbaru
        $recentArticles = Article::with('category')
            ->latest()
            ->take(5)
            ->get();

        // 5 komentar terbaru
        $recentComments = Comment::with(['user', 'article'])
            ->latest()
            ->take(5)
            ->get();

        // Top 5 artikel terpopuler
        $topArticles = Article::published()
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentArticles',
            'recentComments',
            'topArticles'
        ));
    }
}
