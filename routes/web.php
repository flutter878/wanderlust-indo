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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
