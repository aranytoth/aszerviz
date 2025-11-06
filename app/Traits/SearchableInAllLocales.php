<?php

namespace App\Traits;

trait SearchableInAllLocales
{
    
    /**
     * Boot the trait
     */
    public static function bootSearchableInAllLocales()
    {

        static::disableSearchSyncing();

        static::saved(function ($model) {
            $locales = config('app.available_locales', ['hu', 'en']);
            $currentLocale = app()->getLocale();
            
            foreach ($locales as $locale) {
                app()->setLocale($locale);
                $model->searchable();
            }
            
            app()->setLocale($currentLocale);
        });
        
        static::deleting(function ($model) {
            $locales = config('app.available_locales', ['hu', 'en']);
            $currentLocale = app()->getLocale();
            
            foreach ($locales as $locale) {
                app()->setLocale($locale);
                $model->unsearchable();
            }
            
            app()->setLocale($currentLocale);
        });
    }
}