<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_title',
        'ar_title',
        'en_text',
        'ar_text' , 
        'active_status' ,
    ];

}
