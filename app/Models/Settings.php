<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    protected $fillable = [
        'name',
        'value'
    ];

    private static $defaultSettings = [
        'site_name',
        'site_description',
        'site_keywords',
        'site_image',
        'default_timezone',
        'default_date_format',
        'default_time_format',
        'default_admin_email',
        '',
    ];

    protected $casts = [
        'value' => 'array'
    ];

    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget("settings.{$setting->name}");
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("settings.{$key}", function () use ($key, $default) {
            return self::where('name', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, mixed $value): mixed
    {
        if (!in_array($key, self::$defaultSettings)) {
            return false;
        }

        return self::updateOrCreate(
            ['name' => $key],
            ['value' => $value]
        );
    }
}
