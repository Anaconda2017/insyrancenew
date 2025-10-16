<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MotorInsurance extends Model
{
    protected $table = "motor_insurances";

    protected $fillable = [
        'category_id',
        'en_title' ,
        'ar_title' ,
        'year_money',
        'month_money',
        'company_name' ,
        'active_status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function motorClaims()
    {
        return $this->hasMany(MotorClaim::class);
    }

    public function motorRequests()
    {
        return $this->hasMany(MotorRequest::class);
    }

    public function motorchoices()  
    {
        return $this->hasMany(MotorInsuranceChoice::class)->where('active_status' , 1);
    }

    
}
