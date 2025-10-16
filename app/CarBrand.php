<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class CarBrand extends Model
{
    protected $table = "car_brands";

    protected $fillable = [
        'car_type_id',
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

    public function carModels()
    {
        return $this->hasMany(CarModel::class , 'car_brand_id');
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

}
