<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PageType;
use App\Enums\PageStatus;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'content'];


    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'lead_image',
        'order',
        'parent_id',
        'status',
        'type',
        'additional',
    ];

    protected $casts = [
        'additional' => 'array',
        'type' => PageType::class,
        'status' => PageStatus::class,
    ];
}
