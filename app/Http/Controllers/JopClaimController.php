<?php

namespace App\Http\Controllers;

use App\JopClaim;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class JopClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = JopClaim::with('category' ,'user' ,'jopInsurance' ,'comments')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Jop Claims Fetched Successfully',
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
            'jop_insurance_id' => '',  
            'jop_insurance_number' => 'string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'jop_main_id' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',
            'jop_second_id' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',
            'jop_price' => '',
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
        
        
        if($request->hasFile('jop_main_id')){
            $file = $request->file('jop_main_id');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/jop_claims'), $fileName);
            $requestArray['jop_main_id'] = 'uploads/jop_claims/'.$fileName;
        }
        
        
        if($request->hasFile('jop_second_id')){
            $file1 = $request->file('jop_second_id');
            $fileName1 = time().'.'.$file->getClientOriginalExtension();
            $file1->move(public_path('uploads/jop_claims'), $fileName1);
            $requestArray['jop_second_id'] = 'uploads/jop_claims/'.$fileName1;
        }
        
        $requestArray['claim_number'] = $randomString;

        $jopClaim = JopClaim::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Jop Claim Added Successfully',
            'data' => $jopClaim
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
        $row = JopClaim::with('category', 'user', 'jopInsurance' ,'comments')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Jop Claim Fetched Successfully',
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
        $row = JopClaim::findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Jop Claim Fetched Successfully',
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
        $jopClaim = JopClaim::findorFail($id);
        
        $requestArray = $request->all();

        if($request->status != $jopClaim->status) {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotificationClaim';
                            $body['titlemessage'] = 'Update Alert!';
                            $body['textmessage'] = 'Your status has been updated.';
                            $body['artitlemessage'] = 'تنبيه تحديث!';
                            $body['artextmessage'] = 'تم تحديث حالتك. ';
                            $body['user_id'] = $jopClaim->user_id;
                            $body['request_id'] = $jopClaim->id;
                            $body['request_type'] = "job" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }
        
        $jopClaim->update($requestArray);
        
        
        

        return response()->json([
            'success' => true,
            'message' => 'Jop Claim Updaded Successfully',
            'data' => $jopClaim
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
