<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class JopLead extends Model
{
    protected $table = "jop_leads";

    protected $fillable = [
        'category_id',
        'name' ,
        'phone',
        'email',
        'jop_title' ,
        'jop_price' ,
        'jop_main_id' ,
        'jop_second_id' ,
        'company_name' ,
        'company_employee_number' ,
        'company_employee_avg' ,
        'company_employee_total_money' ,
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
