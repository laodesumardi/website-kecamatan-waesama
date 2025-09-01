<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    protected $table = 'berita';
    
    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'konten',
        'gambar',
        'status',
        'is_featured',
        'views',
        'author_id',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'views' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the author of the berita.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
