<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class PageTag extends MorphPivot
{
    protected $table = 'page_tag';

    protected $primaryKey = null;

    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'tag_id'
    ];

    public function tag() : HasOne
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }

    public function page() : HasOne
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
}
