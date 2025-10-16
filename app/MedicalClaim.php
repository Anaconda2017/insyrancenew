<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalClaim extends Model
{
    protected $table = 'medical_claims';
    protected $fillable = [
        'user_id',
        'category_id',
        'claim_number',
        'claim_date',
        'medical_insurance_id' ,
        'medical_insurance_number' ,
        'name' , 
        'email' , 
        'phone' ,
        'birthdate' ,
        'gender' ,
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

    public function medicalInsurance()
    {
        return $this->belongsTo(MedicalInsurance::class);
    }

    public function comments()
    {
        return $this->hasMany(MedicalClaimComment::class , 'claim_id');
    }

}
