<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'order',
        'parent_id'
    ];

    protected $casts = [
        'order' => 'integer',
        'parent_id' => 'integer'
    ];
}
