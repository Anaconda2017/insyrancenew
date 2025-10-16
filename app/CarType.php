<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class CarType extends Model
{
    protected $table = "car_types";

    protected $fillable = [
        'en_title', 
        'ar_title', 
        'active_status',
    ];

    public function motorLeads()
    {
        return $this->hasMany(MotorLead::class);
    }

    public function motorClaims()   
    {
        return $this->hasMany(MotorClaim::class);
    }

    public function motorRequests() 
    {
        return $this->hasMany(MotorRequest::class);
    }

    public function carBrands()
    {
        return $this->hasMany(CarBrand::class);
    }

}
