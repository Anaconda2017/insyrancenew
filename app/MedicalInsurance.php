<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MedicalInsurance extends Model
{
    protected $table = "medical_insurances";

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

    public function medicalClaims()
    {
        return $this->hasMany(MedicalClaim::class);
    }

    public function medicalRequests()
    {
        return $this->hasMany(MedicalRequest::class);
    }


    public function medicalchoices()
    {
        return $this->hasMany(MedicalInsuranceChoice::class)->where('active_status' , 1);
    }
    
}
