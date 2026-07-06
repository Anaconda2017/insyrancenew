<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MedicalRequest extends Model
{
    protected $table = "medical_requests";

    protected $fillable = [
        'user_id',
        'category_id',
        'medical_insurance_id',
        'payment_method',
        'medical_insurance_number',
        'admin_medical_insurance_number',
        'name',
        'email',
        'phone',
        'birthdate',
        'gender',
        'company_id' ,
        'company_name' ,
        'company_employee_number' ,
        'company_employee_avg' , 
        'company_address' ,
        'request_type' ,
        'start_date',
        'duration',
        'end_date',
        'active_status',
        'total_year_money' ,
        'total_month_money' ,
        'policy_id' ,
        'expire_notification' ,
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function medicalInsurance()
    {
        return $this->belongsTo(MedicalInsurance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(MedicalRequestComment::class , 'request_id' , 'id');
    }


}
