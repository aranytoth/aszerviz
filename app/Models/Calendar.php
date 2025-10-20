<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    
    protected $table = 'calendar';
    
    const TYPE_NORMAL = 1;
    const TYPE_HOLIDAY = 2;

    protected $fillable = [
        'type',
        'title',
        'start',
        'end',
        'worksheet_id',
        'user_id',
        'note'
    ];

   
}
