<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    protected $table = 'page_category';

    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'category_id'
    ];
}
