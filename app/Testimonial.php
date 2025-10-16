<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = "testimonials";
    protected $fillable = [
        'en_name',
        'ar_name',
        'en_job',
        'ar_job',
        'en_text',
        'ar_text',
        'active_status'
    ];

   
} 