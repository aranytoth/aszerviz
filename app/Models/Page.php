<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PageType;
use App\Enums\PageStatus;
use App\Traits\SearchableInAllLocales;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;

class Page extends Model
{   
    
    use HasTranslations;
    use Searchable;
    use SearchableInAllLocales;
    
    public $translatable = ['title', 'lead', 'content'];

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'lead',
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

   
    public function pageCategory() : HasOne
    {
        return $this->hasOne(PageCategory::class, 'page_id', 'id');
    }

    public function category() : HasOneThrough
    {
        return $this->hasOneThrough(
            Category::class, 
            PageCategory::class,
            'page_id',
            'id',
            'id',
            'category_id'
        );
    }

    public function getCurrentStatusAttribute() : string
    {
        return $this->status?->label() ?? 'unknown';
    }

    public function toSearchableArray(): array
    {
       $locale = app()->getLocale();
        
        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'lead' => $this->getTranslation('lead', $locale),
            'content' => html_entity_decode(strip_tags($this->getTranslation('content', $locale)), ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
            'slug' => $this->slug,
            'locale' => $locale,
            'status' => $this->status,
            'category' => $this->pageCategory ? $this->pageCategory->category_id : 0
        ];
    }

    public function tags() : HasManyThrough
    {
        return $this->hasManyThrough(
            Tag::class,
            PageTag::class,
            'page_id',
            'id',
            'id',
            'tag_id');
    }

    public function pageTags() : HasMany
    {
        return $this->hasMany(PageTag::class, 'page_id', 'id');
    }

    public function searchableAs() : string
    {
        return 'posts_' . app()->getLocale();
    }

    public function updateTags($tagParams)
    {
        
        $this->pageTags()->delete();
        if($tagParams && count($tagParams) > 0){
                foreach($tagParams as $key => $tag){
                    $pageTag = new PageTag();
                    $pageTag->page_id = $this->id;
                    if(is_numeric($tag)){
                        $pageTag->tag_id = intval($tag);
                    } else {
                        $newTag = new Tag();
                        $newTag->name = intval($tag);
                        $newTag->slug = Str::slug($tag);
                        if($newTag->save()){
                            $pageTag->tag_id = $newTag->id;
                        }
                    }
                    $pageTag->save();
                    
                }
            }
    }

    
}
