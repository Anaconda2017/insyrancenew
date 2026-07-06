<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class Client extends Model
{
    protected $table = "clients";

    protected $fillable = [
        'client_image', 
        'en_client_name', 
        'ar_client_name', 
        'active_status' ,
    ];

    
}
