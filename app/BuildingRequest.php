<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class BuildingRequest extends Model
{
    protected $table = "building_requests";

    protected $fillable = [
        'user_id',
        'category_id',
        'building_insurance_id',
        'company_id' ,
        'payment_method',
        'building_insurance_number',
        'admin_building_insurance_number',
        'name',
        'email',
        'phone',
        'birthdate',
        'gender',
        'building_type_id',
        'building_type',
        'building_country_id',
        'building_country',
        'building_city',
        'building_price',
        'company_name' ,
        'company_building_number' ,
        'company_building_total_money' ,
        'company_address' ,
        'request_type' ,
        'start_date',
        'duration',
        'end_date',
        'active_status',
        'total_year_money' ,
        'total_month_money' ,
        'policy_id', 
        'expire_notification' ,
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function buildingInsurance()
    {
        return $this->belongsTo(BuildingInsurance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(BuildingRequestComment::class , 'request_id' , 'id');
    }


}
