<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\Uploadable;

class WorksheetImage extends Model
{
    use Uploadable;

    protected $table = 'worksheet_images';

    protected $fillable = [
        'worksheet_id',
        'image',
        'has_video',
        'note'
    ];

    public function worksheet() : HasOne
    {
        return $this->hasOne(Worksheet::class, 'id', 'worksheet_id');
    }
}
