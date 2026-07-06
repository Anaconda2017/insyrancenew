<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MotorInsuranceChoice extends Model
{
    protected $table = "motor_insurance_choices";

    protected $fillable = [
        'category_id',
        'motor_insurance_id',
        'en_title' ,
        'ar_title' ,
        'en_description' ,
        'ar_description' ,
        'active_status',
    ];

    public function motorinsurance()
    {
        return $this->belongsTo(MotorInsurance::class , 'motor_insurance_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
