<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasUuids;

    protected $table = 'vehicles';

    protected $fillable = [
        'license_plate',
        'validity_date',
        'brand',
        'chasis_num',
        'man_year',
        'speedometer',
        'engine_code',
        'note'
    ];

    public function worksheets() : HasMany
    {
        return $this->hasMany(Worksheet::class, 'vehicle_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function latestSheet()
    {
        return $this->hasOne(Worksheet::class, 'vehicle_id', 'id')->orderBy('created_at', 'DESC');
    }
}
