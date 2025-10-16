<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $table = 'about_us';
    protected $fillable = [

        'en_main_title' , 
        'ar_main_title' , 
        'en_main_content' , 
        'ar_main_content' , 
        'main_image' , 

        'en_history_title' , 
        'ar_history_title' , 
        'en_history_text' , 
        'ar_history_text' , 
        'history_image' , 

        'en_footer_text',
        'ar_footer_text',

        'en_mission',
        'ar_mission',

        'en_vision',
        'ar_vision',
        
        'en_about_first_feature_title',
        'ar_about_first_feature_title',

        'en_about_second_feature_title',
        'ar_about_second_feature_title',

        'en_about_first_feature_text',
        'ar_about_first_feature_text',

        'en_about_second_feature_text',
        'ar_about_second_feature_text',

        'en_meta_title'  , 
        'ar_meta_title', 
        'en_meta_description' , 
        'ar_meta_description' , 
        'years_of_experience'
    ];   

}
