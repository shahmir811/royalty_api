<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;
    // use HasFactory, Notifiable, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }    

    public function hasRole($role)
    {
        if ($this->role->name == $role) {
            return true;
        }


        return false;
    }   
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }    

    public function getJWTCustomClaims()
    {
        return [];
    }  
    
    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            $name = strtolower($user->name);
            $name = preg_replace('/\s+/', '-', $name);
            $user->slug = strtolower($name) . '-' . time();
        });
    }        

}
