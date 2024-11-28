<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class Manager extends Authenticatable implements JWTSubject
{
    use HasFactory,HasRoles,HasPermissions,Notifiable;

    protected $guarded = [];
    protected $casts = [
        'password' => 'hashed',
    ];
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function image() : Attribute {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }
    public function permissionsAdmin()
    {
        return $this->roles()->first()->permissions;
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'manager_id');
    }
}
