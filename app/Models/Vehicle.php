<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

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
}
