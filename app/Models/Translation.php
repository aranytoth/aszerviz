<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{

    protected $table = 'translations';
    
    public function values()
    {
        return $this->hasMany(TranslationValue::class);
    }
    
    public function getValueForLocale($locale)
    {
        return $this->values()->where('lang', $locale)->first()?->value 
               ?? $this->key;
    }


}
