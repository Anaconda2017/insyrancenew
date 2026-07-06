<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adminstration extends Model
{
    protected $table = "adminstrations";
    protected $fillable = [
        'en_name',
        'ar_name',
        'en_job',
        'ar_job',
        'admin_image',
        'active_status'
    ];

   
} 