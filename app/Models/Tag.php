<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;

    protected $table = 'tags';

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug'
    ];

    public function posts() : HasManyThrough
    {
        return $this->hasManyThrough(
            Page::class,
            PageTag::class,
            'tag_id',
            'id',
            'id',
            'page_id');
    }
}
