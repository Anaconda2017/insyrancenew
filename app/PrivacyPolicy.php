<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $table = "privacy_policy";

    protected $fillable = [
        'en_title',
        'ar_title',
        'en_description',
        'ar_description',
    ];

    
}
