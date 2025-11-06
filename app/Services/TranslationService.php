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
     * Fordítás lekérése dotted notation-nel
     * Példa: trans_db('posts.read_more') vagy trans_db('read_more')
     */
    public function get(string $key, ?string $locale = null, ?string $default = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        // Szétbontjuk a group.key formátumot
        [$group, $actualKey] = $this->parseKey($key);
        
        $translations = $this->getAllForLocale($locale);

        //dd($translations);
        
        // Először próbáljuk a group-os változatot
        $fullKey = $group ? "{$group}.{$actualKey}" : $actualKey;
        
        if (isset($translations[$fullKey])) {
            return $translations[$fullKey];
        }
        
        // Ha nincs group megadva, próbáljuk a 'common' group-ból
        if (!$group && isset($translations["common.{$actualKey}"])) {
            return $translations["common.{$actualKey}"];
        }
        
        return $default ?? $key;
    }
    
    /**
     * Key szétvágása group és key részre
     */
    protected function parseKey(string $key): array
    {
        if (str_contains($key, '.')) {
            $parts = explode('.', $key, 2);
            return [$parts[0], $parts[1]];
        }
        
        return [null, $key];
    }
    
    /**
     * Összes fordítás egy adott nyelvhez (cache-elve)
     * Formátum: ['group.key' => 'value']
     */
    public function getAllForLocale(string $locale): array
    {
        //dd($this->getCacheKey($locale));
       /* return Cache::remember(
            $this->getCacheKey($locale),
            self::CACHE_TTL,
            fn() => $this->loadFromDatabase($locale)
        );*/

        return $this->loadFromDatabase($locale);
    }
    
    /**
     * Fordítások betöltése adatbázisból
     */
    protected function loadFromDatabase(string $locale): array
    {
        $translations = Translation::with(['values' => function($query) use ($locale) {
                $query->where('lang', $locale);
            }])
            ->get();
        
        $result = [];
        foreach ($translations as $translation) {
            $value = $translation->values->first()?->value;
            if ($value) {
                // Kulcs: group.key formátumban
                $fullKey = $translation->group . '.' . $translation->key;
                $result[$fullKey] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Cache kulcs generálása
     */
    protected function getCacheKey(string $locale): string
    {
        return self::CACHE_KEY . '.' . $locale;
    }
    
    /**
     * Cache törlése
     */
    public function clearCache(?string $locale = null): void
    {
        if ($locale) {
            Cache::forget($this->getCacheKey($locale));
        } else {
            $locales = config('app.available_locales', ['hu', 'en']);
            foreach ($locales as $loc) {
                Cache::forget($this->getCacheKey($loc));
            }
        }
    }
    
    /**
     * Fordítások frissítése
     */
    public function updateTranslations(array $translations, string $locale, string $group = 'common'): void
    {
        foreach ($translations as $key => $value) {
            $translation = Translation::firstOrCreate([
                'group' => $group,
                'key' => $key
            ]);
            
            $translation->values()->updateOrCreate(
                ['lang' => $locale],
                ['value' => $value]
            );
        }
        
        $this->clearCache($locale);
    }
    
    /**
     * Group szerinti fordítások lekérése (adminhoz)
     */
    public function getByGroup(string $group, string $locale): array
    {
        return Translation::where('group', $group)
            ->with(['values' => function($query) use ($locale) {
                $query->where('lang', $locale);
            }])
            ->get()
            ->mapWithKeys(function($translation) {
                return [$translation->key => $translation->values->first()?->value ?? ''];
            })
            ->toArray();
    }
    
    /**
     * Összes group lekérése
     */
    public function getAllGroups(): array
    {
        return config('site.translation.groups');
    }
}