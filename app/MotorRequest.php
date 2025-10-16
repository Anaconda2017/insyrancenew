<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MotorRequest extends Model
{
    protected $table = "motor_requests";

    protected $fillable = [
        'user_id',
        'category_id',
        'motor_insurance_id',
        'payment_method',
        'motor_insurance_number',
        'admin_motor_insurance_number',
        'name',
        'email',
        'phone',
        'birthdate',
        'gender',
        'car_type_id',
        'car_type',
        'car_brand_id',
        'car_brand',
        'car_model_id',
        'car_model',
        'car_year_id',
        'car_year',
        'car_price',
        'start_date',
        'duration',
        'end_date',
        'active_status',
        'expire_notification' ,
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function motorInsurance()
    {
        return $this->belongsTo(MotorInsurance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(MotorRequestComment::class , 'request_id' , 'id');
    }


}
