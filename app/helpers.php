<?php

use App\Models\Translation;

if (!function_exists('trans_db')) {
    function trans_db(string $key, ?string $locale = null, ?string $default = null): string
    {
        return app(\App\Services\TranslationService::class)->get($key, $locale, $default);
    }
}