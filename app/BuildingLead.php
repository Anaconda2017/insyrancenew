<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class BuildingLead extends Model
{
    protected $table = "building_leads";

    protected $fillable = [
        'category_id',
        'name' ,
        'phone',
        'email',
        'gender',
        'birth_date',
        'building_type_id' ,
        'building_type' ,
        'building_country_id' ,
        'building_country' ,
        'building_city' ,
        'building_price' ,
        'company_name' ,
        'company_building_number' ,
        'company_building_total_money' ,
        'company_address' ,
        'lead_type' ,
        'need_call' ,
        'active_status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
}
