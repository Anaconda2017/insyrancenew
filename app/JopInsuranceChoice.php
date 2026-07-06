<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class JopInsuranceChoice extends Model
{
    protected $table = "jop_insurance_choices";

    protected $fillable = [
        'category_id',
        'jop_insurance_id',
        'en_title' ,
        'ar_title' ,
        'en_description' ,
        'ar_description' ,
        'active_status',
    ];

    public function jopinsurance()
    {
        return $this->belongsTo(JopInsurance::class , 'jop_insurance_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }   
    
}
