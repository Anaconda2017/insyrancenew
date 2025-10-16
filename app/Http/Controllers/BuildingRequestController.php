<?php

namespace App\Http\Controllers;

use App\BuildingRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use App\BuildingInsurance;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;



class BuildingRequestController extends Controller
{
    public function index()
    {
        $requests = BuildingRequest::with(['user', 'comments' ,'category' ,'buildingInsurance'])
        ->where(function($q) {
            $q->where('request_type', '!=', 'corporate-empolyee')
              ->orWhereNull('request_type');
        })
        ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Building Requests Fetched Successfully',
            'data' => $requests
        ], 200);
    }
   
   // Company Branch 
    
    public function storepolicyUser(Request $request) {
        $user = User::where('id' , $request->user_id)->get()->first();
        if($user) {
            $buildingRequest = BuildingRequest::where('id' , $request->policy_id)->where('user_id' , $user->id)->get()->first();
            if($buildingRequest) {
                if($buildingRequest->active_status == 'confirmed') {
                    $buildingRequestHistory = BuildingRequest::where('company_id' , $user->id)->get()->count();        
                    if($buildingRequestHistory >= $buildingRequest->company_building_number) {
                        
                         return response()->json([
                            'success' => false,
                            'message' => 'Your Policy Reach Users Limit ',
                        ], 404); 
                        
                    } else {
                        $validator = Validator::make($request->all(), [
                            'name' => 'required|string|between:2,100',
                            'phone' => 'required|unique:users',
                            'email' => 'required|string|email|max:100|unique:users',
                            'password' => 'string|between:8,100',
                        ]);
                        
                        if($validator->fails()){
                            return response()->json(['errors' => $validator->errors()], 400);
                        }
                        
                        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $lenthNumber = 10;
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $lenthNumber; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                
                        $randomString =  $randomString; 
                        
                        $name = $request->name;
                        $phone = $request->phone ;
                        $email = $request->email ;
                        $password = $randomString;
                        
                        
                        $newuser = User::create([
                                'name' => $request->name,
                                'phone' => $request->phone,
                                'email' => $request->email,
                                'role' => 'user',
                                'admin_status' => 1 ,
                                'active_status' => 1,
                                'deactive_status' => 0,
                                'password' =>  Hash::make($password),
                                'delete_status' => 0,
                            ]);
                            
                            
                        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $lenthNumber = 10;
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $lenthNumber; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                
                        $randomString =  $randomString;     
                            
                        
                        
                        $buildingRequestNew = BuildingRequest::create([
                                'category_id' => $buildingRequest->category_id,
                                'user_id' => $newuser->id,
                                'building_insurance_id' => $buildingRequest->building_insurance_id,
                                'payment_method' => $buildingRequest->payment_method,
                                'building_insurance_number' => $randomString,
                                'admin_building_insurance_number' => $buildingRequest->admin_building_insurance_number,
                                'name' => $request->name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                                'start_date' => Carbon::now('Africa/Cairo')->format('Y-m-d H:i:s'),
                                'duration' => $buildingRequest->duration,
                                'end_date' => $buildingRequest->end_date,
                                'active_status' => 'confirmed',
                                'company_id' => $buildingRequest->user_id,
                                'company_name' => $buildingRequest->company_name,
                                'company_building_number' => $buildingRequest->company_building_number,
                                'company_building_total_money' => $buildingRequest->company_building_total_money,
                                'company_address' => $buildingRequest->company_address,
                                'request_type' => 'corporate-empolyee' , 
                                'policy_id' => $buildingRequest->id ,
                            ]);
                        
                        
                        
                        Mail::send('frontend.newRegistration' , [
                        'name' => $name , 
                        'phone' => $phone,
                        'email' => $email,
                        'password' => $password,
                        ], function($message) use (
                            $name , 
                            $phone,
                            $email , 
                            $password
                            )
                        {
                            $message->from('bonder@digitalbondmena.com', "Capital Insurance");
                            $message->subject('Your Capital Insurance Account');
                            $message->to($email);
                            
                        });
                        
                        
                        return response()->json([
                            'success' => true,
                            'message' => 'User Created Successfully',
                        ], 200); 
                            
                    }
                    
                    
                } else {
                   return response()->json([
                    'success' => false,
                    'message' => 'Your Policy Not Confirmed yet',
                ], 404); 
                }
            } else {
                 return response()->json([
                    'success' => false,
                    'message' => 'No Policy Found',
                ], 404);
            }
            
            
        } else {
            return response()->json([
            'success' => false,
            'message' => 'No User Found',
        ], 404);
        }
    }
    
    public function deletepolicy(Request $request) {
        $policy = BuildingRequest::where('id' , $request->policy_id)->get()->first();
        if($policy) {
            $policy->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Removed Successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Policy Found',
            ], 404);
        }
    }
    
    public function getotherpolicy(Request $request) {
        $policy = BuildingRequest::where('id' , $request->policy_id)->get()->first();
        if($policy) {
            $user = User::where('id' , $policy->user_id)->get()->first();
            $empolyeepolicy =  BuildingRequest::where('policy_id' , $request->policy_id)->get()->first() ;
            
            return response()->json([
                    'success' => true,
                    'policy' => $policy,
                    'empolyeepolicy' => $empolyeepolicy
                ], 200);
            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Policy Found',
            ], 404);
        }
    }

    public function store(Request $request)
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lenthNumber = 10;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenthNumber; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString =  $randomString; 
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'building_insurance_id' => 'required|exists:building_insurances,id',
            'payment_method' => 'string',
            'building_insurance_number' => $randomString,
            'admin_building_insurance_number' => 'string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'birthdate' => '',
            'gender' => 'string',
            'building_type' => 'string',
            'building_country' => 'string',
            'building_city' => 'string',
            'building_price' => 'numeric',
            'start_date' => 'date',
            'duration' => 'string',
            'end_date' => 'date',
            'active_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();
        
        $policy = BuildingInsurance::where('id' , $request->building_insurance_id)->get()->first();
        $numbers = $request->company_building_number;
        
        
        $requestArray['building_insurance_number'] = $randomString;
        if($numbers) {
            
            $requestArray = ['total_year_money' => $policy->year_money*$numbers , 'total_month_money' => $policy->month_money*$numbers] + $requestArray;
        }
        
        
        
        
        $buildingRequest = BuildingRequest::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Request Created Successfully',
            'data' => $buildingRequest
        ], 201);

            
    }

    public function show($id)
    {
        $buildingRequest = BuildingRequest::findorfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Building Request Fetched Successfully',
            'data' => $buildingRequest
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $buildingRequest = BuildingRequest::findorfail($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'building_insurance_id' => 'required|exists:building_insurances,id',
            'payment_method' => 'string',
            'admin_building_insurance_number' => 'string',
            'start_date' => 'date',
            'duration' => 'string',
            'end_date' => 'date',
            'active_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        if($request->end_date == null) {
            if($request->active_status == 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You Must Complete Policy Data First',
                ], 400);
            }
        }
        

        if($request->active_status != $buildingRequest->active_status) {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $buildingRequest->user_id;
                            $body['request_id'] = $buildingRequest->id;
                            $body['request_type'] = "building" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }
        $buildingRequest->update($request->all());
        
        
        return response()->json([
            'success' => true,
            'message' => 'Building Request Updated Successfully',
            'data' => $buildingRequest
        ], 200);
    }


    public function destroy($id)
    {
        $buildingRequest = BuildingRequest::findorfail($id);
        $buildingRequest->update(['active_status' => 'canceled']);
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $buildingRequest->user_id;
                            $body['request_id'] = $buildingRequest->id;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

        return response()->json([
            'success' => true,
            'message' => 'Building Request Deleted Successfully',
            'data' => $buildingRequest
        ], 200);
    }

    public function recover($id , Request $request)
    {
        $buildingRequest = BuildingRequest::findorfail($id);
        
        if($buildingRequest->end_date == null) {
            if($request->active_status == 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You Must Complete Policy Data First',
                ], 400);
            }
        }
        
        $buildingRequest->update(['active_status' => $request->active_status]);
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $buildingRequest->user_id;
                            $body['request_id'] = $buildingRequest->id;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

        return response()->json([
            'success' => true,
            'message' => 'Building Request Recovered Successfully',
            'data' => $buildingRequest
        ], 200);
  
    }
} 