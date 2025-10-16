<?php

namespace App\Http\Controllers;

use App\User;
use App\MotorRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;



class MotorRequestController extends Controller
{
    public function index()
    {

        $requests = MotorRequest::with(['user', 'comments' ,'category' ,'motorInsurance'])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Motor Requests Fetched Successfully',
            'data' => $requests
        ], 200);
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
            'motor_insurance_id' => 'required|exists:motor_insurances,id',
            'payment_method' => 'string',
            'motor_insurance_number' => $randomString,
            'admin_motor_insurance_number' => 'string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'birthdate' => '',
            'gender' => 'string',
            'car_type' => 'string',
            'car_brand' => 'string',
            'car_model' => 'string',
            'car_year' => 'string',
            'car_price' => 'numeric',
            'start_date' => 'date',
            'duration' => 'string',
            'end_date' => 'date',
            'active_status' => 'required',
        ]);

        // Generate unique request number
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();
        
        $requestArray['motor_insurance_number'] = $randomString;
        

        $motorRequest = MotorRequest::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Request Created Successfully',
            'data' => $motorRequest
        ], 201);
    }

    public function show($id)
    {
        $motorRequest = MotorRequest::findorfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Motor Request Fetched Successfully',
            'data' => $motorRequest
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $motorRequest = MotorRequest::findorfail($id);
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'motor_insurance_id' => 'required|exists:motor_insurances,id',
            'admin_motor_insurance_number' => 'string',
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'birthdate' => 'date',
            'gender' => 'string',
            'car_type_id' => 'exists:car_types,id',
            'car_type' => 'string',
            'car_brand_id' => 'exists:car_brands,id',
            'car_brand' => 'string',
            'car_model_id' => 'exists:car_models,id',
            'car_model' => 'string',
            'car_year_id' => 'exists:car_years,id',
            'car_year' => 'string',
            'car_price' => 'numeric',
            'start_date' => 'date',
            'duration' => 'string',
            'end_date' => 'date',
            'active_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $requestArray = $request->all();
        
        
        if($request->end_date == null) {
            if($request->active_status == 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You Must Complete Policy Data First',
                ], 400);
            }
        }

        
        if($request->active_status != $motorRequest->active_status) {
            
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $motorRequest->user_id;
                            $body['request_id'] = $motorRequest->id;
                            $body['request_type'] = "motor" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }
        $motorRequest->update($requestArray);
        
        

        return response()->json([
            'success' => true,
            'message' => 'Motor Request Updated Successfully',
            'data' => $motorRequest
        ], 200);
    }

    public function destroy($id)
    {
        $motorRequest = MotorRequest::findorfail($id);
        $motorRequest->update(['active_status' => 'canceled']);
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $motorRequest->user_id;
                            $body['request_id'] = $motorRequest->id;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        
        return response()->json([   
            'success' => true,
            'message' => 'Motor Request Deleted Successfully',
            'data' => $motorRequest
        ], 200);
    }

    public function recover($id , Request $request)
    {
        $motorRequest = MotorRequest::findorfail($id);
        
        if($motorRequest->end_date == null) {
            if($request->active_status == 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'You Must Complete Policy Data First',
                ], 400);
            }
        }
        
        
        $motorRequest->update(['active_status' => $request->active_status]);
        
        
        $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $motorRequest->user_id;
                            $body['request_id'] = $motorRequest->id;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);

        return response()->json([
            'success' => true,
            'message' => 'Motor Request Recovered Successfully',
            'data' => $motorRequest
        ], 200);
        
    }
} 