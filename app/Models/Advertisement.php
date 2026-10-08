<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public const POSITIONS = [
        'header' => 'Header center - 728 x 90',
        'article-top' => 'Top of article - 728 x 90',
        'article-center' => 'Center of article - 728 x 90',
        'article-bottom' => 'Bottom of article - 728 x 90',
        'latest-bottom' => 'Bottom of latest section - 728 x 90',
        'sidebar' => 'Right sidebar - 300 x 250',
        'footer' => 'Footer - 728 x 90',
        'insights-top' => 'Top of insights - 728 x 90',
    ];

    protected $fillable = [
        'title',
        'position',
        'banner_path',
        'click_url',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }
}
