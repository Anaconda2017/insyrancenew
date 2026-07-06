<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JopClaimComment extends Model
{
    protected $table = 'jop_claim_comments';
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
        return $this->belongsTo(JopClaim::class , 'claim_id');
    }

}
