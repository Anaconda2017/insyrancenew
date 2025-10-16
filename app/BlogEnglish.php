<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogEnglish extends Model
{
    protected $table = 'blog_englishes';
    protected $fillable = [
        'en_blog_title',
        'en_blog_text',
        'main_image' , 
        
        'en_slug' , 
        'blog_date' , 
        
        'en_meta_title', 
        'en_meta_text',
        
        'en_first_script_text' ,
        'en_second_script_text' ,
        
        'active_status' ,
         
        ];   

}
