<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingClaim extends Model
{
    protected $table = 'building_claims';
    protected $fillable = [
        'user_id',
        'category_id',
        'claim_number',
        'claim_date',
        'building_insurance_id' ,
        'building_insurance_number' ,
        'name' , 
        'email' , 
        'phone' ,
        'birthdate' ,
        'gender' ,
        'building_type_id' ,
        'building_type' ,
        'building_country_id' ,
        'building_country' ,
        'building_city' ,
        'building_price' ,
        'status' ,
        'description'
        ];   

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buildingInsurance()
    {
        return $this->belongsTo(BuildingInsurance::class);
    }

    public function comments()
    {
        return $this->hasMany(BuildingClaimComment::class , 'claim_id' );
    }

}
