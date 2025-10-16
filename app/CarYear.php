<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class CarYear extends Model
{
    protected $table = "car_years";

    protected $fillable = [
        'car_model_id',
        'year_date', 
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

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
    

}
