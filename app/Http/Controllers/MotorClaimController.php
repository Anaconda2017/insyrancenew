<?php

namespace App\Http\Controllers;

use App\MotorClaim;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MotorClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = MotorClaim::with('category' ,'user' ,'motorInsurance' ,'comments')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Motor Claims Fetched Successfully',
            'data' => $rows
        ], 200); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.client.create');  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'motor_insurance_id' => '',  
            'motor_insurance_number' => 'string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'birthdate' => '',
            'gender' => 'string|max:255',
            'car_brand' => 'string|max:255',
            'car_model' => 'string|max:255',
            'car_year' => 'string|max:255',
            'car_price' => 'numeric',
            'status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $characters = '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lenthNumber = 10;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenthNumber; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString =  $randomString; 

        $requestArray = $request->all();
        $requestArray['claim_number'] = $randomString;

        $motorClaim = MotorClaim::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Added Successfully',
            'data' => $motorClaim
        ], 200);
    }        
     
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = MotorClaim::with('category', 'user', 'motorInsurance' ,'comments')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Fetched Successfully',
            'data' => $row
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = MotorClaim::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Fetched Successfully',
            'data' => $row
        ], 200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $motorClaim = MotorClaim::findorFail($id);
        
        $requestArray = $request->all();

        if($request->status != $motorClaim->status) {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotificationClaim';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $motorClaim->user_id;
                            $body['request_id'] = $motorClaim->id;
                            $body['request_type'] = "motor" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }
        $motorClaim->update($requestArray);
        

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Updaded Successfully',
            'data' => $motorClaim
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
