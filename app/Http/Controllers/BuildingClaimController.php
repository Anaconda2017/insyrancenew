<?php

namespace App\Http\Controllers;

use App\BuildingClaim;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class BuildingClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = BuildingClaim::with('category' ,'user' ,'buildingInsurance' ,'comments')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Building Claims Fetched Successfully',
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
            'building_insurance_id' => '',  
            'building_insurance_number' => 'string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'birthdate' => '',
            'gender' => 'string|max:255',
            'building_type_id' => '',
            'building_country_id' => '',
            'building_country' => 'string|max:255',
            'building_city' => 'string|max:255',
            'building_price' => 'numeric',
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

        $buildingClaim = BuildingClaim::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Building Claim Added Successfully',
            'data' => $buildingClaim
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
        $row = BuildingClaim::with('category', 'user', 'buildingInsurance' ,'comments')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Claim Fetched Successfully',
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
        $row = BuildingClaim::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Building Claim Fetched Successfully',
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
        $buildingClaim = BuildingClaim::findorFail($id);
        
        $requestArray = $request->all();

        if($request->status != $buildingClaim->status) {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotificationClaim';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $buildingClaim->user_id;
                            $body['request_id'] = $buildingClaim->id;
                            $body['request_type'] = "building" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }
        
        $buildingClaim->update($requestArray);
        

        return response()->json([
            'success' => true,
            'message' => 'Building Claim Updaded Successfully',
            'data' => $buildingClaim
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
