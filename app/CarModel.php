<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class CarModel extends Model
{
    protected $table = "car_models";

    protected $fillable = [
        'car_brand_id',
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

    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function carYears()
    {
        return $this->hasMany(CarYear::class);
    }

    

}
