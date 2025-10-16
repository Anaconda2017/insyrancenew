<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class ContactInformation extends Model
{
    protected $table = "contact_information";

    protected $fillable = [
        
        'en_address',
        'ar_address',
        'google_plus',

        'first_phone', 
        'second_phone',
        'third_phone',
        'fourth_phone',
        'whatsapp',

        'email',

        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'snapchat',
        'telegram',
        'tiktok',
        
        'en_contact_title',
        'ar_contact_title',
        'en_contact_text',
        'ar_contact_text',

        'en_meta_title',
        'ar_meta_title',
        'en_meta_description',
        'ar_meta_description',
    ];

}
