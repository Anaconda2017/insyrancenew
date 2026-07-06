<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use App\Services\NotificationService;
use App\Enums\NotificationType;
use Carbon\Carbon;
use App\MotorRequest;
use App\JopRequest;
use App\BuildingRequest;
use App\MedicalRequest;
use App\Services\NotificationDispatchService;

class NotifyBeforeExpire extends Command
{
    protected $signature = 'notify:before-expire';
    protected $description = 'Send notification to users before 7 days of job expire date';

    public function handle()
    {
        $fromDate = Carbon::now()->format('d-m-Y'); // 18-09-2025
        $toDate   = Carbon::now()->addDays(30)->format('d-m-Y'); // 25-09-2025
        
        $Motorjobs = MotorRequest::where('expire_notification' , 0)->whereBetween('end_date', [$fromDate, $toDate])->get();
        
        $Buildingjobs = BuildingRequest::where('expire_notification' , 0)->whereBetween('end_date', [$fromDate, $toDate])->get();
        
        $Medicaljobs = MedicalRequest::where('expire_notification' , 0)->whereBetween('end_date', [$fromDate, $toDate])->get();
        
        $Jopjobs = JopRequest::where('expire_notification' , 0)->whereBetween('end_date', [$fromDate, $toDate])->get();

        // dd($jobs->count() , $fromDate , $toDate);
        foreach ($Motorjobs as $job) {
            app(NotificationDispatchService::class)->dispatchSingle([
                'titlemessage' => '⚠️ Reminder',
                'textmessage' => 'Your policy is about to expire soon. Please take action to renew.',
                'user_id' => $job->user_id,
                'request_id' => $job->id,
                'request_type' => 'motor',
            ]);
        }
        
        
        foreach ($Buildingjobs as $job) {
            app(NotificationDispatchService::class)->dispatchSingle([
                'titlemessage' => '⚠️ Reminder',
                'textmessage' => 'Your policy is about to expire soon. Please take action to renew.',
                'user_id' => $job->user_id,
                'request_id' => $job->id,
                'request_type' => 'building',
            ]);
        }
        
        
        foreach ($Medicaljobs as $job) {
            app(NotificationDispatchService::class)->dispatchSingle([
                'titlemessage' => '⚠️ Reminder',
                'textmessage' => 'Your policy is about to expire soon. Please take action to renew.',
                'user_id' => $job->user_id,
                'request_id' => $job->id,
                'request_type' => 'medical',
            ]);
        }
        
        
        foreach ($Jopjobs as $job) {
            app(NotificationDispatchService::class)->dispatchSingle([
                'titlemessage' => '⚠️ Reminder',
                'textmessage' => 'Your policy is about to expire soon. Please take action to renew.',
                'user_id' => $job->user_id,
                'request_id' => $job->id,
                'request_type' => 'job',
            ]);
        }
        
            // dump($URI_Response);

        $this->info('Notifications sent successfully.');
    }
}
