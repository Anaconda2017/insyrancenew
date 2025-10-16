<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MedicalLead extends Model
{
    protected $table = "medical_leads";

    protected $fillable = [
        'category_id',
        'name' ,
        'phone',
        'email',
        'gender',
        'birth_date',
        'company_name' ,
        'company_employee_number' ,
        'company_employee_avg' , 
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
