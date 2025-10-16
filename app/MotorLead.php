<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MotorLead extends Model
{
    protected $table = "motor_leads";

    protected $fillable = [
        'category_id',
        'name' ,
        'phone',
        'email',
        'gender',
        'birth_date',
        'need_call' ,
        'car_type_id',
        'car_type',
        'car_brand_id' ,
        'car_brand' ,
        'car_model_id',
        'car_model',
        'car_year_id',
        'car_year',
        'car_price',
        'active_status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
}
