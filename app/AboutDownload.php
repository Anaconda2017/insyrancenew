<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutDownload extends Model
{
    protected $table = "about_downloads";
    protected $fillable = [
        'en_title',
        'ar_title',
        'en_text',
        'ar_text',
        'android_download_link',
        'ios_download_link' ,
        'huawei_download_link' ,
        'main_download_link',
        'elwinsh_link'
    ];

   
} 