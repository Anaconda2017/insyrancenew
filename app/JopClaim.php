<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JopClaim extends Model
{
    protected $table = 'jop_claims';
    protected $fillable = [
        'user_id',
        'category_id',
        'claim_number',
        'claim_date',
        'jop_insurance_id' ,
        'jop_insurance_number' ,
        'name' , 
        'email' , 
        'phone' ,
        'jop_title' ,
        'jop_price' ,
        'jop_main_id' ,
        'jop_second_id' ,
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

    public function jopInsurance()
    {
        return $this->belongsTo(JopInsurance::class);
    }

    public function comments()
    {
        return $this->hasMany(JopClaimComment::class , 'claim_id');
    }

}
