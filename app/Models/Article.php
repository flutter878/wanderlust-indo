<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'image_gallery',
        'location_name',
        'map_embed',
        'latitude',
        'longitude',
        'ticket_price_info',
        'operating_hours',
        'status',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'image_gallery' => 'array',   // otomatis encode/decode JSON
            'latitude'      => 'decimal:7',
            'longitude'     => 'decimal:7',
            'views'         => 'integer',
        ];
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    /**
     * Hanya artikel yang sudah dipublikasi.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Urutkan berdasarkan artikel terpopuler (views terbanyak).
     */
    public function scopePopular($query)
    {
        return $query->orderByDesc('views');
    }

    /**
     * Urutkan berdasarkan artikel terbaru.
     */
    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * Admin yang membuat artikel.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori artikel.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Komentar pada artikel.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Data favorit pada artikel.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
