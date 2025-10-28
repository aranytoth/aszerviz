<?php

// app/Services/TranslationService.php
namespace App\Services;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    protected const CACHE_KEY = 'translations';
    protected const CACHE_TTL = 86400; // 24 óra
    
    /**
     * Fordítás lekérése cache-ből vagy adatbázisból
     */
    public function get(string $key, ?string $locale = null, ?string $default = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $translations = $this->getAllForLocale($locale);
        
        return $translations[$key] ?? $default ?? $key;
    }
    
    /**
     * Összes fordítás egy adott nyelvhez (cache-elve)
     */
    public function getAllForLocale(string $locale): array
    {
        return Cache::remember(
            $this->getCacheKey($locale),
            self::CACHE_TTL,
            fn() => $this->loadFromDatabase($locale)
        );
    }
    
    /**
     * Fordítások betöltése adatbázisból
     */
    protected function loadFromDatabase(string $locale): array
    {
        return Translation::with(['values' => function($query) use ($locale) {
                $query->where('lang', $locale);
            }])
            ->get()
            ->pluck('values.0.value', 'key')
            ->filter()
            ->toArray();
    }
    
    /**
     * Cache kulcs generálása
     */
    protected function getCacheKey(string $locale): string
    {
        return self::CACHE_KEY . '.' . $locale;
    }
    
    /**
     * Cache törlése (amikor szerkesztés történik)
     */
    public function clearCache(?string $locale = null): void
    {
        if ($locale) {
            Cache::forget($this->getCacheKey($locale));
        } else {
            // Összes nyelv cache törlése
            $locales = config('app.available_locales', ['hu', 'en']);
            foreach ($locales as $loc) {
                Cache::forget($this->getCacheKey($loc));
            }
        }
    }
    
    /**
     * Fordítások frissítése és cache törlése
     */
    public function updateTranslations(array $translations, string $locale): void
    {
        foreach ($translations as $key => $value) {
            $translation = Translation::firstOrCreate(['key' => $key]);
            
            $translation->values()->updateOrCreate(
                ['lang' => $locale],
                ['value' => $value]
            );
        }
        
        $this->clearCache($locale);
    }
}