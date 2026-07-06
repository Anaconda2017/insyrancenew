<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotorClaimComment extends Model
{
    protected $table = 'motor_claim_comments';
    protected $fillable = [
        'user_id',
        'user_role',
        'user_name' , 

        'comment' , 
        'comment_file' ,
        'comment_date' ,

        'reciver_id',
        'reciver_role',
        'reciver_name',

        'claim_id',
        'claim_number' ,
        'claim_status',
        ];   

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function reciver()   
    {
        return $this->belongsTo(User::class , 'reciver_id');
    }

    public function claim()
    {
        return $this->belongsTo(MotorClaim::class , 'claim_id');
    }

}
