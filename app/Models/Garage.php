<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Garage extends Model
{
    use HasUuids;

    protected $table = 'garages';

    protected $with = ['company'];

    protected $fillable = [
        'name',
        'email',
        'user_id',
        'company_id',
        'phone',
        'website',
        'zip',
        'city',
        'address',
        'housenum',
        //'prefix',
        'status'
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function company() : HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    private function createPrefix() : string
    {
        $string = str_replace(' ', '-', $this->name);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = Str::upper(substr($string, 0, 2));

        return $string;
    }
}
