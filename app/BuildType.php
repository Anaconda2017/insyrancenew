<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class BuildType extends Model
{
    protected $table = "build_types";

    protected $fillable = [
        'en_title', 
        'ar_title', 
        'active_status',
    ];

    public function buildingLeads()
    {
        return $this->hasMany(BuildingLead::class);
    }

    public function buildingClaims()   
    {
        return $this->hasMany(BuildingClaim::class);
    }

    public function buildingRequests() 
    {
        return $this->hasMany(BuildingRequest::class);
    }

    public function buildCountry()
    {
        return $this->hasMany(BuildCountry::class);
    }

}
