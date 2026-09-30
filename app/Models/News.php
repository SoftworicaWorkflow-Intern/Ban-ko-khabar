<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'status',
        'image_url',
        'media_type',
        'author',
        'views',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Estimated reading time in whole minutes, using the common 200 words/min
     * convention. Nepali script has no spaces between words, so tokens are
     * counted rather than using str_word_count().
     */
    public function readMinutes(): int
    {
        $text = implode(' ', array_filter([
            $this->title,
            $this->excerpt,
            $this->content,
        ]));

        $text = trim((string) preg_replace('/\s+/u', ' ', strip_tags($text)));
        $words = $text === ''
            ? 0
            : count(preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Human readable read time for the articles table, e.g. "३ मिनेट".
     */
    public function readTime(): string
    {
        return self::toDevanagariDigits($this->readMinutes()).' मिनेट';
    }

    /**
     * Convert Latin digits to their Devanagari equivalents.
     */
    public static function toDevanagariDigits(int|string $value): string
    {
        return strtr((string) $value, [
            '0' => '०',
            '1' => '१',
            '2' => '२',
            '3' => '३',
            '4' => '४',
            '5' => '५',
            '6' => '६',
            '7' => '७',
            '8' => '८',
            '9' => '९',
        ]);
    }
}
