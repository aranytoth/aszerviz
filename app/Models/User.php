<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Image\Enums\Fit;

class User extends Authenticatable implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    
    const STATUS_ACTIVE = 10;
    const STATUS_SUSPENDED = 11;

    const ROLE_MECHANIC = 'mechanic';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $with = ['company'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'garage_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $roles = [
        self::ROLE_MECHANIC => 'Szerelő',
        self::ROLE_ADMIN => 'Admin'
    ];

    public static $status = [
        self::STATUS_ACTIVE => 'Aktív',
        self::STATUS_SUSPENDED => 'Felfüggesztve'
    ];

    public function getCurrentStatusAttribute()
    {
        if($this->status == self::STATUS_SUSPENDED){
            return self::$status[self::STATUS_SUSPENDED];
        } elseif (empty($this->email_verified_at)){
            return 'pending';
        } else {
            return self::$status[self::STATUS_ACTIVE];
        }
    }

    public function getCurrentRolesAttribute()
    {
        $roles = $this->getRoleNames()->toArray();
        
        return self::$roles[$roles[0]];
    }

    public function company() : HasOne
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function garage() : HasOne
    {
        return $this->hasOne(Garage::class, 'id', 'garage_id');
    }

    public function garageOwner() : HasOne
    {
        return $this->hasOne(Garage::class, 'user_id', 'id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
{
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
