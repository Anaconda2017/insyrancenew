<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class Features extends Model
{
    protected $table = "features";

    protected $fillable = [
        'en_description' , 
        'ar_description' , 
        'active_status'
    ];

}
