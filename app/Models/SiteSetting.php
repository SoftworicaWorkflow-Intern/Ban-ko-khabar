<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const HOMEPAGE_BIKRAM_SAMBAT_DATE = 'homepage_bikram_sambat_date_enabled';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function homepageBikramSambatDateEnabled(): bool
    {
        return static::query()
            ->where('key', self::HOMEPAGE_BIKRAM_SAMBAT_DATE)
            ->value('value') !== '0';
    }
}
