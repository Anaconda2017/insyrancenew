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
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

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
            
                $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = '⚠️ Reminder';
                            $body['textmessage'] = 'Your policy is about to expire soon. Please take action to renew.';
                            $body['user_id'] = $job->user_id;
                            $body['request_id'] = $job->id;
                            $body['request_type'] = "motor" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

                
        }
        
        
        foreach ($Buildingjobs as $job) {
            
                $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = '⚠️ Reminder';
                            $body['textmessage'] = 'Your policy is about to expire soon. Please take action to renew.';
                            $body['user_id'] = $job->user_id;
                            $body['request_id'] = $job->id;
                            $body['request_type'] = "building" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

                
        }
        
        
        foreach ($Medicaljobs as $job) {
            
                $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = '⚠️ Reminder';
                            $body['textmessage'] = 'Your policy is about to expire soon. Please take action to renew.';
                            $body['user_id'] = $job->user_id;
                            $body['request_id'] = $job->id;
                            $body['request_type'] = "medical" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

               
        }
        
        
        foreach ($Jopjobs as $job) {
            
                $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = '⚠️ Reminder';
                            $body['textmessage'] = 'Your policy is about to expire soon. Please take action to renew.';
                            $body['user_id'] = $job->user_id;
                            $body['request_id'] = $job->id;
                            $body['request_type'] = "job" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

                
        }
        
            // dump($URI_Response);

        $this->info('Notifications sent successfully.');
    }
}
