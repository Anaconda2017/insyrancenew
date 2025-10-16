<?php

namespace App\Http\Controllers;

use App\MotorClaimComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MotorClaimCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rows = MotorClaimComment::where('claim_id', $id)->with('user', 'reciver', 'claim')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Comments Fetched Successfully',
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
            'user_id' => 'required|exists:users,id',
            'user_role' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string|max:255',
            'comment_file' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',
            'comment_date' => Carbon::now('Africa/Cairo')->format('Y-m-d H:i:s'),
            'reciver_id' => 'required|exists:users,id',
            'reciver_role' => 'required|string|max:255',
            'reciver_name' => 'required|string|max:255',
            'claim_id' => 'required|exists:motor_claims,id',
            'claim_number' => 'required|string|max:255',
            'claim_status' => 'required|string|max:255',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray =  $request->all();

        if($request->hasFile('comment_file')){
            $file = $request->file('comment_file');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/motor_claim_comments'), $fileName);
            $requestArray['comment_file'] = 'uploads/motor_claim_comments/'.$fileName;
        }
        
        $requestArray['comment_date'] = Carbon::now('Africa/Cairo')->format('Y-m-d H:i:s');
        
        
        if($request->user_role == 'admin') {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotificationClaim';
                            $body['titlemessage'] = 'New Comment!';
                            $body['textmessage'] = 'You have a new comment received. Tap to view and respond';
                            $body['artitlemessage'] = 'تعليق جديد!';
                            $body['artextmessage'] = 'لديك تعليق جديد. اضغط للعرض والرد.';
                            $body['user_id'] = $request->reciver_id;
                            $body['request_id'] = $request->claim_id;
                            $body['request_type'] = "motor" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }

        $motorClaimComment = MotorClaimComment::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Comment Added Successfully',
            'data' => $motorClaimComment
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
        $row = MotorClaimComment::with('user', 'reciver', 'claim')->findorfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Comment Fetched Successfully',
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
        $row = MotorClaimComment::with('user', 'reciver', 'claim')->findorFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Comment Fetched Successfully',
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
        $motorClaimComment = MotorClaimComment::findorFail($id);
        
        if($request->hasFile('comment_file')){
            $file = $request->file('comment_file');
            $fileName = time().'.'.$file->getClientOriginalExtension();

            // Delete old image if exists
            if ($motorClaimComment->comment_file) {
                $oldImage = public_path('uploads/motor_claim_comments/' . $motorClaimComment->comment_file);
                if (file_exists($oldImage)) unlink($oldImage);
            }
            
            $file->move(public_path('uploads/motor_claim_comments'), $fileName);
            $requestArray['comment_file'] = 'uploads/motor_claim_comments/'.$fileName;
        }

        $requestArray = $request->all();

        $motorClaimComment->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Claim Comment Updaded Successfully',
            'data' => $motorClaimComment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
