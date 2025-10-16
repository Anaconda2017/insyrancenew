<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSenderClaim extends Model
{
    protected $fillable = [
        'user_id', 
        'notification_title',
        'ar_notification_title' , 
        'notification_text',
        'ar_notification_text' ,
        'notification_date',
        'notification_time',
        'request_id',
        'request_type' ,
    ];   

    /**
     * رجع علاقة belongsTo لأي موديل
     */
    protected function relation($model)
    {
        return $this->belongsTo($model, 'request_id');
    }

    // Building
    public function buildingClaim()         { return $this->relation(BuildingClaim::class); }

    // Jop
    public function jopClaim()              { return $this->relation(JopClaim::class); }
    
    // Medical
    public function medicalClaim()          { return $this->relation(MedicalClaim::class); }

    // Motor
    public function motorClaim()            { return $this->relation(MotorClaim::class); }
}
