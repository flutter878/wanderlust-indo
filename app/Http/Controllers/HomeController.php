<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Artikel terbaru (8 artikel)
        $latestArticles = Article::published()
            ->with(['category', 'user'])
            ->latest()
            ->take(8)
            ->get();

        // Artikel terpopuler (4 artikel)
        $popularArticles = Article::published()
            ->with(['category', 'user'])
            ->popular()
            ->take(4)
            ->get();

        // Artikel hero (1 artikel terbaru untuk banner)
        $heroArticle = $latestArticles->first();

        // Semua kategori
        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('home', compact(
            'latestArticles',
            'popularArticles',
            'heroArticle',
            'categories'
        ));
    }
}
