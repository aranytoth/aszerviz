<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WorksheetItem extends Model
{
    use HasUuids;

    protected $table = 'worksheet_items';

    public $units = [
        1 => 'darab',
        2 => 'óra',
        3 => 'liter',
        4 => 'kg'
    ];

    protected $fillable = [
        'worksheet_id',
        'item_num',
        'item_name',
        'quantity',
        'unit',
        'unit_price',
        'discount',
        'vat',
        'is_work'
    ];

    public function getUnitNameAttribute()
    {
        return $this->units[$this->unit];
    }
}
