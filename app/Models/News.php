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
        'author',
        'views',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
