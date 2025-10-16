<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutCounter extends Model
{
    protected $fillable = [
        'en_name',
        'ar_name',
        'counter_value',
        'active_status'
    ];

   
} 