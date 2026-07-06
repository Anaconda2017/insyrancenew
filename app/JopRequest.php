<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class JopRequest extends Model
{
    protected $table = "jop_requests";

    protected $fillable = [
        'user_id',
        'category_id',
        'jop_insurance_id',
        'payment_method',
        'jop_insurance_number',
        'admin_medical_insurance_number',
        'name',
        'email',
        'phone',
        'jop_title',
        'jop_price' ,
        'jop_main_id',
        'jop_second_id' ,
        'company_id' ,
        'company_name' ,
        'company_employee_number' ,
        'company_employee_avg' ,
        'company_employee_total_money' ,
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

    public function jopInsurance()
    {
        return $this->belongsTo(JopInsurance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(JopRequestComment::class , 'request_id' , 'id');
    }


}
