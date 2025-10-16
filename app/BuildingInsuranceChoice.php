<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class BuildingInsuranceChoice extends Model
{
    protected $table = "building_insurance_choices";

    protected $fillable = [
        'category_id',
        'building_insurance_id',
        'en_title' ,
        'ar_title' ,
        'en_description' ,
        'ar_description' ,
        'active_status',
    ];

    public function buildinginsurance()
    {
        return $this->belongsTo(BuildingInsurance::class , 'building_insurance_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
