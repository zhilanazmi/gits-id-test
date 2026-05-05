<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'publisher_id',
        'isbn',
        'description',
        'published_at',
        'pages',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'pages' => 'integer',
        ];
    }

    /**
     * Get the author that owns the book.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the publisher that owns the book.
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
