<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apple_id' , 
        'google_id' ,
        'name', 
        'phone', 
        'email', 
        'gender',
        'device_token' ,
        'birth_date',
        'password', 
        'role',
        'admin_status',
        'active_status',
        'deactive_status',
        'delete_status',
        'forget_code' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function medicalclaims()
    {
        return $this->hasMany(MedicalClaim::class);
    }
    
    public function medicalpolicy()
    {
        return $this->hasMany(MedicalRequest::class);
    }

    public function medicalclaimcomments()
    {
        return $this->hasMany(MedicalClaimComment::class);
    }

    public function motorclaims()
    {
        return $this->hasMany(MotorClaim::class);
    }
    
    public function motorpolicy()
    {
        return $this->hasMany(MotorRequest::class);
    }

    public function motorclaimcomments()
    {
        return $this->hasMany(MotorClaimComment::class);
    }

    public function buildingclaims()
    {
        return $this->hasMany(BuildingClaim::class);
    }
    
    public function buildingpolicy()
    {
        return $this->hasMany(BuildingRequest::class);
    }

    public function buildingclaimcomments()
    {
        return $this->hasMany(BuildingClaimComment::class);
    }
    
    
    public function buildingcompanypolicy()
    {
        return $this->hasMany(BuildingRequest::class , 'company_id' , 'id');
    }
    
    public function medicalcompanypolicy()
    {
        return $this->hasMany(MedicalRequest::class , 'company_id' , 'id');
    }
    
    
    public function jopcompanypolicy()
    {
        return $this->hasMany(JopRequest::class , 'company_id' , 'id');
    }
    
}
