<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    protected $table = 'translation_values';

    protected $fillable = [
        'translation_id',
        'lang',
        'value'
    ];
}
