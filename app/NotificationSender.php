<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSender extends Model
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
    public function buildingRequest()       { return $this->relation(BuildingRequest::class); }

    // Jop
    public function jopRequest()            { return $this->relation(JopRequest::class); }

    // Medical
    public function medicalRequest()        { return $this->relation(MedicalRequest::class); }

    // Motor
    public function motorRequest()          { return $this->relation(MotorRequest::class); }
}
