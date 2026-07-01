<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Artikel Wisata
|--------------------------------------------------------------------------
*/

// ── Homepage ─────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Artikel Publik ────────────────────────────────────────────────────────────
Route::get('/cari', [ArticleController::class, 'search'])->name('articles.search');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// ── Route yang membutuhkan login ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Komentar
    Route::post('/artikel/{article}/komentar', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/komentar/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Favorit
    Route::get('/favorit', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorit/{article}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Artikel (CRUD)
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class)
        ->except(['show']);

    // Komentar (moderasi)
    Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

    // Kategori (CRUD via satu halaman)
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__ . '/auth.php';
