<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogArabic extends Model
{
    protected $table = 'blog_arabics';
    protected $fillable = [
        'ar_blog_title',
        'ar_blog_text',
        'main_image' , 
        
        'ar_slug' , 
        'blog_date' ,    
        
        'ar_meta_title', 
        'ar_meta_text',
        
        'ar_first_script_text' ,
        'ar_second_script_text' ,
        
        'active_status' ,

        ];   

}
