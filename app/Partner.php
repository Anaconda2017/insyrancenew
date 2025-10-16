<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\GlobalState\Restorer;

class Partner extends Model
{
    protected $table = "partners";

    protected $fillable = [
        'partner_image', 
        'en_partner_name', 
        'ar_partner_name', 
        'category_id',
        'active_status' ,
        'home_status' , 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
