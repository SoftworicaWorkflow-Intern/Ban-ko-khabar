<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    public const POSITIONS = [
        'header' => 'Header center - 728 x 90',
        'article-top' => 'Top of article - 728 x 90',
        'article-center' => 'Center of article - 728 x 90',
        'article-bottom' => 'Bottom of article - 728 x 90',
        'latest-bottom' => 'Bottom of Latest - 728 x 90',
        'categories-bottom' => 'Between categories and trending - 728 x 90',
        'trending-bottom' => 'Bottom of trending - 728 x 90',
        'sidebar' => 'Right sidebar - 300 x 250',
        'footer' => 'Footer - 728 x 90',
        'insights-top' => 'Top of insights - 728 x 90',
        'insights-bottom' => 'Between insights and gallery - 728 x 90',
        'gallery-bottom' => 'Bottom of gallery - 728 x 90',
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

    /**
     * @return Collection<int, self>
     */
    public static function homepageHeaderBanners(): Collection
    {
        $currentTime = now();

        return static::query()
            ->where('active', true)
            ->where('position', '!=', 'sidebar')
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $currentTime);
            })
            ->where(function ($query) use ($currentTime) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $currentTime);
            })
            ->orderByRaw('CASE WHEN position = ? THEN 0 ELSE 1 END', ['header'])
            ->latest()
            ->get()
            ->take(2)
            ->values();
    }
}
