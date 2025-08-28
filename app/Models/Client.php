<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasUuids;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'company_vat',
        'zip',
        'city',
        'address',
        'housenum',
        'note'
    ];
}
