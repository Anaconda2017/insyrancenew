<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotorClaim extends Model
{
    protected $table = 'motor_claims';
    protected $fillable = [
        'user_id',
        'category_id',
        'claim_number',
        'claim_date',
        'motor_insurance_id' ,
        'motor_insurance_number' ,
        'name' , 
        'email' , 
        'phone' ,
        'birthdate' ,
        'gender' ,
        'car_type_id' ,
        'car_type' ,
        'car_brand_id' ,
        'car_brand' ,
        'car_model_id' ,
        'car_model' ,
        'car_year_id' ,
        'car_year' ,
        'car_price' ,
        'description' ,
        'status' ,
        ];   

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function motorInsurance()
    {
        return $this->belongsTo(MotorInsurance::class);
    }

    public function comments()
    {
        return $this->hasMany(MotorClaimComment::class , 'claim_id');
    }

}
