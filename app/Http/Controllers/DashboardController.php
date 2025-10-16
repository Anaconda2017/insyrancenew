<?php

namespace App\Http\Controllers;

use App\Algorithm;
use App\ContactUsForm;
use App\FrequentlyAskedQuestion;
use App\GuideLineMain;
use App\Http\Controllers\Controller;
use App\Newsletter;
use App\User;
use App\UserTimeSpent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\NotificationSender;
use App\NotificationSenderClaim;
use App\BuildingRequest;
use App\JopRequest;
use App\MedicalRequest;
use App\MotorRequest;
use App\BuildingClaim;
use App\JopClaim;
use App\MedicalClaim;
use App\MotorClaim;
use App\BuildingRequestComment;
use App\JopRequestComment;
use App\MedicalRequestComment;
use App\MotorRequestComment;
use App\BuildingClaimComment;
use App\JopClaimComment;
use App\MedicalClaimComment;
use App\MotorClaimComment;

class DashboardController extends Controller
{
    public function index() {
        $users = User::where('active_status' , 1)->count();
        $algorithms = Algorithm::where('algorithm_status' , 1)->count();
        $guidelines = GuideLineMain::where('guide_line_status'  , 1)->count();
        $totalSpentTime = UserTimeSpent::sum('user_time_spent_time');
        $totalFormSubmition = ContactUsForm::count();
        $totalFAQS = FrequentlyAskedQuestion::where('frequently_asked_question_status' , 1)->count();
        $totalNews = Newsletter::where('newsletter_status' , 1)->count();
        
        $activeUserscurrents = User::where('active_status' , 1)->get();
            
            foreach($activeUserscurrents as $activeUser){
                $spenttie = $activeUser->userTimeSpent;
                if(count($spenttie)){
                    $usersNumberactivecurrent[] = $activeUser;
                }
            }

        return response()->json([
            'users' => $users,
            'algorithms' => $algorithms,
            'guidelines' => $guidelines,
            'totalSpentTime' => $totalSpentTime,
            'totalFormSubmition' => $totalFormSubmition,
            'totalFAQS' => $totalFAQS,
            'totalNews' => $totalNews,
            'activeUsers' => count($usersNumberactivecurrent) , 
             ], 200); 
    }
    
    public function customnumbers(Request $request) {
        $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
        
        $singleDate = $request->single_date;
        
        $usersNumberactive = [];
                    
        if($singleDate) {
            $dateNow = Carbon::now('Africa/Cairo')->format('Y-m-d');
            $users = User::whereDate('created_at' , '=' , $singleDate)->where('active_status' , 1)->count();
            $algorithms = Algorithm::whereDate('created_at' , '=' , $singleDate)->where('algorithm_status' , 1)->count();
            $guidelines = GuideLineMain::whereDate('guide_line_date' , '=' , $singleDate)->where('guide_line_status'  , 1)->count();
            $totalSpentTime = UserTimeSpent::whereDate('user_time_spent_date' , '=' , $singleDate)->sum('user_time_spent_time');
            $totalFormSubmition = ContactUsForm::whereDate('created_at' , '=' , $singleDate)->count();
            $totalFAQS = FrequentlyAskedQuestion::whereDate('created_at' , '=' , $singleDate)->where('frequently_asked_question_status' , 1)->count();
            
            $activeUsers = User::where('active_status' , 1)->get();
            
            foreach($activeUsers as $activeUser){
                $spenttie = $activeUser->onlineactiveUser($singleDate);
                if(count($spenttie)){
                    $usersNumberactive[] = $activeUser;
                }
            }
            
            
        }  else if ($request->start_date) {
            
            // dd($startDate , $endDate);
            $fromdate = $request->start_date;
            $todate = $request->end_date;
            // dd($fromdate , $todate);
            
            $users = User::whereDate('created_at' , '>=' , $fromdate)->whereDate('created_at' , '<=' , $todate)->where('active_status' , 1)->count();
            $algorithms = Algorithm::whereDate('created_at' , '>=' , $fromdate)->whereDate('created_at' , '<=' , $todate)->where('algorithm_status' , 1)->count();
            $guidelines = GuideLineMain::whereDate('guide_line_date' , '>=' , $fromdate)->whereDate('guide_line_date' , '<=' , $todate)->where('guide_line_status'  , 1)->count();
            $totalSpentTime = UserTimeSpent::whereDate('user_time_spent_date' , '>=' , $fromdate)->whereDate('user_time_spent_date' , '<=' , $todate)->sum('user_time_spent_time');
            $totalFormSubmition = ContactUsForm::whereDate('created_at' , '>=' , $fromdate)->whereDate('created_at' , '<=' , $todate)->count();
            $totalFAQS = FrequentlyAskedQuestion::whereDate('created_at' , '>=' , $fromdate)->whereDate('created_at' , '<=' , $todate)->where('frequently_asked_question_status' , 1)->count();
            
            $activeUsers = User::where('active_status' , 1)->get();
            
            foreach($activeUsers as $activeUser){
                $spenttie = $activeUser->onlineactiveUserInBetween($fromdate , $todate);
                if(count($spenttie)){
                    $usersNumberactive[] = $activeUser;
                }
            }
            
            
        }   else {
            
            $users = User::whereDate('created_at' , '=' , $dateNow)->where('active_status' , 1)->count();
            $algorithms = Algorithm::whereDate('created_at' , '=' , $dateNow)->where('algorithm_status' , 1)->count();
            $guidelines = GuideLineMain::whereDate('guide_line_date' , '=' , $dateNow)->where('guide_line_status'  , 1)->count();
            $totalSpentTime = UserTimeSpent::whereDate('user_time_spent_date' , '=' , $dateNow)->sum('user_time_spent_time');
            $totalFormSubmition = ContactUsForm::whereDate('created_at' , '=' , $dateNow)->count();
            $totalFAQS = FrequentlyAskedQuestion::whereDate('created_at' , '=' , $dateNow)->where('frequently_asked_question_status' , 1)->count();
            
            $activeUsers = User::where('active_status' , 1)->get();
            
            foreach($activeUsers as $activeUser){
                $spenttie = $activeUser->onlineactiveUser($dateNow);
                if(count($spenttie)){
                    $usersNumberactive[] = $activeUser;
                }
            }
            
            

            
        }   
        
        
        $userscurrent = User::where('active_status' , 1)->count();
            $algorithmscurrent = Algorithm::where('algorithm_status' , 1)->count();
            $guidelinescurrent = GuideLineMain::where('guide_line_status'  , 1)->count();
            $totalSpentTimecurrent = UserTimeSpent::sum('user_time_spent_time');
            $totalFormSubmitioncurrent = ContactUsForm::count();
            $totalFAQScurrent = FrequentlyAskedQuestion::where('frequently_asked_question_status' , 1)->count();
            
            $activeUserscurrents = User::where('active_status' , 1)->get();
            
            foreach($activeUserscurrents as $activeUser){
                $spenttie = $activeUser->userTimeSpent;
                if(count($spenttie)){
                    $usersNumberactivecurrent[] = $activeUser;
                }
            }
        
        // dd(count($usersNumberactive));
        

        return response()->json([
            'users' => $users,
            'algorithms' => $algorithms,
            'guidelines' => $guidelines,
            'totalSpentTime' => $totalSpentTime,
            'totalFormSubmition' => $totalFormSubmition,
            'totalFAQS' => $totalFAQS,
            'activeUsers' => count($usersNumberactive) , 
            
            'usersTotal' => $userscurrent,
            'algorithmsTotal' => $algorithmscurrent,
            'guidelinesTotal' => $guidelinescurrent,
            'totalSpentTimeTotal' => $totalSpentTimecurrent,
            'totalFormSubmitionTotal' => $totalFormSubmitioncurrent,
            'totalFaqsTotal' => $totalFAQScurrent,
            'activeUsersTotal' => count($usersNumberactivecurrent) , 
            
            
             ], 200); 
    }
    
    public function sendAllUsersNotification(Request $request) 
    {
        $message = $request->textmessage;
        $title = $request->titlemessage;
        $armessage = $request->artextmessage;
        $artitle = $request->artitlemessage;
        
        $client = new Client();

        // Prepare the data to send in the POST request
        // dd($title , $message);

    
        
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendPushNotification';
                            $body['titlemessage'] = $title;
                            $body['textmessage'] = $message;
                            $body['artitlemessage'] = $artitle;
                            $body['artextmessage'] = $armessage;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

    
        return response()->json(['success' => 'Notifications sent to all users'], 200);
    }
    
    public function getNotificationLog(Request $request) {
        $adminNotification = NotificationSender::where('user_id' , null)->latest()->get();
        
        $userID = $request->user_id ; 
        if($userID) {
            
            $userPolicyNotifications = NotificationSender::where('user_id' , $userID)->latest()->get();
            if($userPolicyNotifications) {
                
                foreach($userPolicyNotifications as $userPolicyNotification) {
                    if($userPolicyNotification->request_type == 'building') {
                        $policy = BuildingRequest::where('id' , $userPolicyNotification->request_id)->get()->first();
                    } else if ($userPolicyNotification->request_type == 'job') {
                        $policy = JopRequest::where('id' , $userPolicyNotification->request_id)->get()->first();
                    } else if ($userPolicyNotification->request_type == 'medical') {
                        $policy = MedicalRequest::where('id' , $userPolicyNotification->request_id)->get()->first();
                    } else if ($userPolicyNotification->request_type == 'motor') {
                        $policy = MotorRequest::where('id' , $userPolicyNotification->request_id)->get()->first();
                    }
                    
                    $userPolicyNotification->policy = $policy;
                }
            }
            
            $userClaimNotifications = NotificationSenderClaim::where('user_id' , $userID)->latest()->get();
            if($userClaimNotifications) {
                
                foreach($userClaimNotifications as $userClaimNotification) {
                    if($userClaimNotification->request_type == 'building') {
                        $policy = BuildingClaim::where('id' , $userClaimNotification->request_id)->get()->first();
                    } else if ($userClaimNotification->request_type == 'job') {
                        $policy = JopClaim::where('id' , $userClaimNotification->request_id)->get()->first();
                    } else if ($userClaimNotification->request_type == 'medical') {
                        $policy = MedicalClaim::where('id' , $userClaimNotification->request_id)->get()->first();
                    } else if ($userClaimNotification->request_type == 'motor') {
                        $policy = MotorClaim::where('id' , $userClaimNotification->request_id)->get()->first();
                    }
                    
                    $userClaimNotification->claim = $policy;
                }
            }
            
        } 
        
        
        return response()->json([
            'generalNotify' => $adminNotification , 
            'policyNotify' => $userPolicyNotifications ,
            'claimNotify' => $userClaimNotifications,
            
            ], 200);
        
    }
    
    
    public function getExpirePolicy() {
        $fromDate = Carbon::now()->format('d-m-Y');       // 18-09-2025
        $toDate   = Carbon::now()->addDays(7)->format('d-m-Y'); // 25-09-2025
        
        // نحولهم لصيغة Y-m-d عشان المقارنة في STR_TO_DATE
        $fromDateSql = Carbon::createFromFormat('d-m-Y', $fromDate)->format('Y-m-d');
        $toDateSql   = Carbon::createFromFormat('d-m-Y', $toDate)->format('Y-m-d');
        
        $Motorjobs = MotorRequest::whereRaw(
            "STR_TO_DATE(end_date, '%d-%m-%Y') BETWEEN ? AND ?",
            [$fromDateSql, $toDateSql]
        )->get();
        
        $Buildingjobs = BuildingRequest::whereRaw(
            "STR_TO_DATE(end_date, '%d-%m-%Y') BETWEEN ? AND ?",
            [$fromDateSql, $toDateSql]
        )->get();
        
        $Medicaljobs = MedicalRequest::whereRaw(
            "STR_TO_DATE(end_date, '%d-%m-%Y') BETWEEN ? AND ?",
            [$fromDateSql, $toDateSql]
        )->get();
        
        $Jopjobs = JopRequest::whereRaw(
            "STR_TO_DATE(end_date, '%d-%m-%Y') BETWEEN ? AND ?",
            [$fromDateSql, $toDateSql]
        )->get();

        
        return response()->json([
            'Motorjobs' => $Motorjobs,
            'Buildingjobs' => $Buildingjobs,
            'Medicaljobs' => $Medicaljobs,
            'Jopjobs' => $Jopjobs,
             ], 200); 
        
    }
    
    
    public function getpolicy(Request $request) {
        $policyID = $request->request_id;
        $policyType = $request->request_type;
        
        if($policyType == 'building') {
            $Buildingjobs = BuildingRequest::where('id', $policyID)->get()->first();
        } else if ($policyType == 'job') {
            $Jopjobs = JopRequest::where('id', $policyID)->get()->first();
        } else if ($policyType == 'medical') {
            $Medicaljobs = MedicalRequest::where('id', $policyID)->get()->first();
        } else if ($policyType == 'motor') {
            $Motorjobs = MotorRequest::where('id', $policyID)->get()->first();
        }
    }
    
    
    public function getclaim(Request $request) {
        $policyID = $request->request_id;
        $policyType = $request->request_type;
        
        if($policyType == 'building') {
            $Buildingjobs = BuildingClaim::where('id', $policyID)->get()->first();
        } else if ($policyType == 'job') {
            $Jopjobs = JopClaim::where('id', $policyID)->get()->first();
        } else if ($policyType == 'medical') {
            $Medicaljobs = MedicalClaim::where('id', $policyID)->get()->first();
        } else if ($policyType == 'motor') {
            $Motorjobs = MotorClaim::where('id', $policyID)->get()->first();
        }
    }

    public function admincommecnts(Request $request) {
        $fromDate = Carbon::now()->format('Y-m-d'); // 18-09-2025
        // dd($fromDate);
        
        $Motorjobs = MotorRequestComment::with(['request'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $Buildingjobs = BuildingRequestComment::with(['request'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $Medicaljobs = MedicalRequestComment::with(['request'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $Jopjobs = JopRequestComment::with('request')->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        
        $MotorClaimjobs = MotorClaimComment::with(['claim'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $BuildingClaimjobs = BuildingClaimComment::with(['claim'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $MedicalClaimjobs = MedicalClaimComment::with(['claim'])->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        $JopClaimjobs = JopClaimComment::with('claim')->latest()->whereDate('comment_date' , $fromDate)->where('reciver_role' , 'admin')->limit(5)->get();
        
        return response()->json([
            'MotorComment' => $Motorjobs,
            'BuildingComment' => $Buildingjobs,
            'MedicalComment' => $Medicaljobs,
            'JopComment' => $Jopjobs,
            'MotorClaimComment' => $MotorClaimjobs,
            'BuildingClaimComment' => $BuildingClaimjobs,
            'MedicalClaimComment' => $MedicalClaimjobs,
            'JopClaimComment' => $JopClaimjobs,
             ], 200); 
    }
    
}
