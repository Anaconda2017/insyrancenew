<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class JopInsurance extends Model
{
    protected $table = "jop_insurances";

    protected $fillable = [
        'category_id',
        'en_title' ,
        'ar_title' ,
        'year_money',
        'month_money',
        'company_name' ,
        'active_status',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jopClaims()
    {
        return $this->hasMany(JopClaim::class);
    }

    public function jopRequests()
    {
        return $this->hasMany(JopRequest::class);
    }


    public function jopchoices()
    {
        return $this->hasMany(JopInsuranceChoice::class)->where('active_status' , 1);
    }
    
}
