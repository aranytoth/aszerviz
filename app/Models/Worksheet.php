<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Worksheet extends Model
{
    use HasUuids;
    
    protected $table = 'worksheet';

    protected $with = ['client', 'vehicle', 'items', 'images'];

    protected $fillable = [
        'garage_id',
        'worksheet_id',
        'client_id',
        'vehicle_id',
        'name',
        'status',
        'mechanic_user_id',
        'station_id',
        'note',
        'calc_price',
        'warranty',
        'old_parts',
        'history'
    ];

    protected $casts = [
        'history' => 'array'
    ];

    const STATUS_OPEN = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_CLOSED = 10;
    const STATUS_DELETED = 11;

    public static $statuses = [
        self::STATUS_OPEN => 'Nyitott',
        self::STATUS_PROGRESS => 'Folyamatban',
        self::STATUS_CLOSED => 'Lezárt',
        self::STATUS_DELETED => 'Törölve'
    ];

    public function client() : HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function vehicle() : HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function items() : HasMany
    {
        return $this->hasMany(WorksheetItem::class, 'worksheet_id', 'id');
    }

    public function images() : HasMany
    {
        return $this->hasMany(WorksheetImage::class, 'worksheet_id', 'id');
    }

    public function garage() : HasOne
    {
        return $this->hasOne(Garage::class, 'id', 'garage_id');
    }

    public function mechanic() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'mechanic_user_id');
    }

    public function createWorkSheetId()
    {
        $user = Auth::user();
        if(!empty($user->garage_id)){
            $worksheetCount = Worksheet::where('garage_id', $user->garage->id)->whereYear('created_at', date('Y'))->count();
            $this->worksheet_id = $user->garage->company->prefix.'-'.date('Y').'-'.$worksheetCount+1;
        } elseif(!empty($user->company)){
            $worksheetCount = Worksheet::whereYear('created_at', date('Y'))->count();
            $this->worksheet_id = $user->company->prefix.'A-'.date('Y').'-'.$worksheetCount+1;
        }
    }

    public function getCurrentStatusAttribute()
    {
        return self::$statuses[$this->status];
    }

    public function getIsClosedAttribute()
    {
        return $this->status == self::STATUS_CLOSED;
    }

    public function getTotalNettoAttribute()
    {
        $totalNetto = 0;
        foreach($this->items as $item){
            $totalNetto += ($item->unit_price * $item->quantity);
        }
        return $totalNetto;
    }

    public function getTotalVatAttribute()
    {
        $totalVat = 0;
        foreach($this->items as $item){
            $totalVat += ($item->unit_price/100 * $item->vat * $item->quantity);
        }
        return $totalVat;
    }
}
