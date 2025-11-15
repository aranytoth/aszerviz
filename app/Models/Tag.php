<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function posts()
    {
        return $this->hasMany(
            Page::class,
            PageTag::class,
            'page_id',
            'id',
            'id',
            'tag_id');
    }
}
