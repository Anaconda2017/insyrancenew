<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class BuildingInsurance extends Model
{
    protected $table = "building_insurances";

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

    public function buildingClaims()
    {
        return $this->hasMany(BuildingClaim::class);
    }

    public function buildingRequests()
    {
        return $this->hasMany(BuildingRequest::class);
    }

    public function buildingchoices()
    {
        return $this->hasMany(BuildingInsuranceChoice::class)->where('active_status' , 1);
    }

    
}
