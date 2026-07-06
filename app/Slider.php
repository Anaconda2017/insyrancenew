<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
   

    protected $table = "sliders";

    protected $fillable = [
        'en_title',
        'ar_title',
        'en_description',
        'ar_description',
        'image',
        'active_status' ,
    ];
}
