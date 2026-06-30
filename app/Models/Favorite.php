<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * Tabel ini tidak menggunakan kolom updated_at.
     */
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'article_id',
        'bookmarked_at',
    ];

    protected function casts(): array
    {
        return [
            'bookmarked_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * User yang memfavoritkan artikel.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Artikel yang difavoritkan.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
