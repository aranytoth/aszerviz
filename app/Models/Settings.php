<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value'
    ];

    public static $defaultSettings = [
        'site_name',
        'site_description',
        'site_keywords',
        'site_image',
        'default_timezone',
        'default_date_format',
        'default_time_format',
        'default_admin_email',
        'default_admin_url',
        'default_admin_login'
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

    public static function get(string $key): mixed
    {
        return Cache::rememberForever("settings.{$key}", function () use ($key) {

            return self::where('name', $key)->value('value');
        });
    }

    public static function set(string $key, mixed $value): mixed
    {
        if (in_array($key, self::$defaultSettings)) {
            return false;
        }

        return self::updateOrCreate(
            ['name' => $key],
            ['value' => $value]
        );
    }
}
