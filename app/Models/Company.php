<?php

namespace App\Models;

use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasUuids, Uploadable;

    const STATUS_DRAFT = 1;
    const STATUS_LIVE = 10;
    const STATUS_SUSPENDED = 11;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes); // Szülő konstruktor meghívása
        // További inicializálás, ha szükséges
        $this->uploadImageName = 'company_logo';
    }

    protected $table = 'company';

    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'company_tax_number',
        'company_zip',
        'company_city',
        'company_address',
        'company_house_num',
        'company_logo',
        'szamlazz_api_key',
        'prefix',
        'status'
    ];

    public static $statuses = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_LIVE => 'Élő',
        self::STATUS_SUSPENDED => 'Felfüggesztve'
    ];

    public function getCurrentStatusAttribute()
    {
        return self::$statuses[$this->status];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function createPrefix() : string
    {
        $string = str_replace(' ', '', $this->company_name);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = Str::upper(substr($string, 0, 2));
        return $string;
    }
}
