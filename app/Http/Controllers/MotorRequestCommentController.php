<?php

namespace App\Http\Controllers;

use App\MotorRequestComment;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MotorRequestCommentController extends Controller
{
    public function index($id)
    {
        $comments = MotorRequestComment::where('request_id', $id)->with(['user', 'reciver', 'request'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Motor Request Comments Fetched Successfully',
            'data' => $comments
        ], 200);
    }

    public function store($id , Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'user_role' => 'required|string',
            'user_name' => 'required|string',

            'comment' => 'required|string',
            'comment_file' => 'mimes:jpg,jpeg,png,gif,svg,pdf,svg|max:2048',

            'reciver_id' => 'required|exists:users,id',
            'reciver_role' => 'required|string',
            'reciver_name' => 'required|string',

            'request_id' => 'required|exists:motor_requests,id',
            'request_status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $requestArray = $request->all();

        if($request->hasFile('comment_file')){
            $file = $request->file('comment_file');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/motor_request_comments'), $fileName);
            $requestArray['comment_file'] = 'uploads/motor_request_comments/'.$fileName;
        }

        $requestArray['comment_date'] = Carbon::now('Africa/Cairo')->format('Y-m-d H:i:s');
        
        if($request->user_role == 'admin') {
            $client = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
                        'Accept' => '*/*',
                                ]
                                    ]);
                            $URI = 'https://digitalbondmena.com/insurancenotification/sendSingleNotification';
                            $body['titlemessage'] = 'New Comment!';
                            $body['textmessage'] = 'You have a new comment received. Tap to view and respond';
                            $body['artitlemessage'] = 'تعليق جديد!';
                            $body['artextmessage'] = 'لديك تعليق جديد. اضغط للعرض والرد.';
                            $body['user_id'] = $request->reciver_id;
                            $body['request_id'] = $request->request_id;
                            $body['request_type'] = "motor" ;
                            
                            $URI_Response = $client->request('GET',$URI,['body'=>json_encode($body)]);
                            $URI_Response =json_decode($URI_Response->getBody(), true);
        }

        $comment = MotorRequestComment::create($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Request Comment Added Successfully',
            'data' => $comment
        ], 201);
    }

    public function show($id)
    {
        $comment = MotorRequestComment::findorfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Motor Request Comment Fetched Successfully',
            'data' => $comment
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $comment = MotorRequestComment::findorfail($id);

        $validator = Validator::make($request->all(), [
            'comment' => 'sometimes|required|string',
            'comment_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if($request->hasFile('comment_file')){
            $file = $request->file('comment_file');
            $fileName = time().'.'.$file->getClientOriginalExtension();

            // Delete old image if exists
            if ($comment->comment_file) {
                $oldImage = public_path('uploads/motor_request_comments/' . $comment->comment_file);
                if (file_exists($oldImage)) unlink($oldImage);
            }
            
            $file->move(public_path('uploads/motor_request_comments'), $fileName);
            $requestArray['comment_file'] = 'uploads/motor_request_comments/'.$fileName;
        }

        $comment->update($requestArray);

        return response()->json([
            'success' => true,
            'message' => 'Motor Request Comment Updated Successfully',
            'data' => $comment
        ], 200);

    }
} 