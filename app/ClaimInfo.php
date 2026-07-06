<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimInfo extends Model
{
    protected $table = 'claim_info';
    protected $fillable = [
        'en_main_title' , 
        'ar_main_title' , 
        'en_main_text' , 
        'ar_main_text' ,
        'main_image' , 
        
        'en_second_title' , 
        'ar_second_title' , 
        'en_second_text' , 
        'ar_second_text' ,

        'en_meta_title'  , 
        'ar_meta_title', 
        'en_meta_text' , 
        'ar_meta_text'
    ];   

}
