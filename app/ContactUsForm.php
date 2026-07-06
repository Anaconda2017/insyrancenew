<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsForm extends Model
{
    protected $table = 'contact_us_form';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read'
        ];     

}
