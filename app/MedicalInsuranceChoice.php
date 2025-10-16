<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class MedicalInsuranceChoice extends Model
{
    protected $table = "medical_insurance_choices";

    protected $fillable = [
        'category_id',
        'medical_insurance_id',
        'en_title' ,
        'ar_title' ,
        'en_description' ,
        'ar_description' ,
        'active_status',
    ];

    public function medicalinsurance()
    {
        return $this->belongsTo(MedicalInsurance::class , 'medical_insurance_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }   
    
}
