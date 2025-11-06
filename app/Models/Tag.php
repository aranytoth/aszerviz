<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

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
