<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'en_title',
        'ar_title',
        'en_slug',
        'ar_slug',

        'en_small_description',
        'ar_small_description',

        'en_main_description',
        'ar_main_description',
        'network_link',

        'counter_number' ,

        'en_meta_title',
        'ar_meta_title',
        'en_meta_description',
        'ar_meta_description',
        
        'ar_first_script' ,
        'en_first_script' ,

        'active_status',
    ];

    public function medicalClaims()
    {
        return $this->hasMany(MedicalClaim::class);
    }

    public function motorClaims()
    {
        return $this->hasMany(MotorClaim::class);
    }


    public function buildingClaims()
    {
        return $this->hasMany(BuildingClaim::class);
    }
    
    public function jopClaims()
    {
        return $this->hasMany(JopClaim::class);
    }


    public function medicalLeads()
    {
        return $this->hasMany(MedicalLead::class);
    }

    public function motorLeads()
    {
        return $this->hasMany(MotorLead::class);
    }

    public function buildingLeads()
    {
        return $this->hasMany(BuildingLead::class);
    }
    
    public function jopLeads()
    {
        return $this->hasMany(JopLead::class);
    }


    public function medicalRequests()
    {
        return $this->hasMany(MedicalRequest::class);
    }

    public function motorRequests()
    {
        return $this->hasMany(MotorRequest::class);
    }
    
    public function buildingRequests()
    {
        return $this->hasMany(BuildingRequest::class);
    }
    
    public function jopRequests()
    {
        return $this->hasMany(JopRequest::class);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class)->where('active_status' , 1);
    }

    public function medicalinsurances()
    {
        return $this->hasMany(MedicalInsurance::class)->where('active_status' , 1);
    }

    public function motorinsurances()
    {
        return $this->hasMany(MotorInsurance::class)->where('active_status' , 1);
    }

    public function buildinginsurances()
    {
        return $this->hasMany(BuildingInsurance::class)->where('active_status' , 1);
    }
    
    public function jopinsurances()
    {
        return $this->hasMany(JopInsurance::class)->where('active_status' , 1);
    }
    

} 