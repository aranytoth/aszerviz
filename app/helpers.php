<?php

use App\Models\Translation;
use App\Models\Settings;

if (!function_exists('trans_db')) {
    function trans_db(string $key, ?string $locale = null, ?string $default = null): string
    {
        return app(\App\Services\TranslationService::class)->get($key, $locale, $default);
    }
}

if (!function_exists('get_option')) {
    function get_option(string $key, mixed $default = null): mixed
    {
        if(env('DISABLE_SETTINGS', false)) {
            return $default;
        }
        return Settings::get($key) ?? $default;
    }
}

if (!function_exists('update_option')) {
    function update_option(string $key, mixed $value): mixed
    {
        return Settings::set($key, $value);
    }
}